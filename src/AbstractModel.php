<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder;

use Nsbx\Bundle\ModelBuilder\Mapping\Collection;
use Nsbx\Bundle\ModelBuilder\Mapping\Model;
use Nsbx\Bundle\ModelBuilder\Mapping\Property;
use Nsbx\Bundle\ModelBuilder\Mapping\PropertyCollection;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

abstract class AbstractModel implements ModelInterface
{
    private ?PropertyAccessorInterface $propertyAccessor = null;

    public function __construct(mixed $modelData)
    {
        $this->buildModel($modelData);
    }

    private function getPropertyAccessor(): PropertyAccessorInterface
    {
        if ($this->propertyAccessor === null) {
            $this->propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
                ->disableExceptionOnInvalidIndex()
                ->disableExceptionOnInvalidPropertyPath()
                ->getPropertyAccessor();
        }

        return $this->propertyAccessor;
    }

    public function __call(string $name, array $arguments): mixed
    {
        $propertyAccessor = $this->getPropertyAccessor();

        switch (true) {
            case str_starts_with($name, 'get'):
                $methodPath = substr($name, 3);
                $methodPath = lcfirst($methodPath);
                return $propertyAccessor->getValue($this, $methodPath);
            case str_starts_with($name, 'set'):
                $methodPath = substr($name, 3);
                $methodPath = lcfirst($methodPath);
                $propertyAccessor->setValue(
                    $this,
                    $methodPath,
                    current($arguments),
                );
                return $this;
        }
    }

    public function buildModel(\stdClass|array $modelData): void
    {
        foreach ($this->getMapping()->getMappingOptions() as $mappingOption) {
            switch (true) {
                case $mappingOption instanceof Property:
                    $this->buildPropertyOption($mappingOption, $modelData);
                    break;
                case $mappingOption instanceof Model:
                    $this->buildModelOption($mappingOption, $modelData);
                    break;
                case $mappingOption instanceof Collection:
                    $this->buildCollectionOption($mappingOption, $modelData);
                    break;
                case $mappingOption instanceof PropertyCollection:
                    $this->buildPropertyCollectionOption(
                        $mappingOption,
                        $modelData,
                    );
                    break;
            }
        }
    }

    private function buildPropertyOption(
        Property $mappingOption,
        mixed $modelData,
    ): void {
        $propertyAccessor = $this->getPropertyAccessor();

        $propertyData = $this->getValueOrNull($modelData, $mappingOption->path);

        if (
            $mappingOption->alternativePath !== null &&
            $propertyData === null
        ) {
            $propertyData = $this->getValueOrNull(
                $modelData,
                $mappingOption->alternativePath,
            );
        }

        $propertyAccessor->setValue(
            $this,
            $mappingOption->property,
            $propertyData,
        );
    }

    private function buildModelOption(
        Model $mappingOption,
        mixed $modelData,
    ): void {
        $propertyAccessor = $this->getPropertyAccessor();

        $propertyData = $this->getValueOrNull($modelData, $mappingOption->path);
        $modelClass = $mappingOption->modelClass;

        try {
            $itemModel = new $modelClass($propertyData);
        } catch (\TypeError $e) {
            if (!$mappingOption->nullable) {
                throw $e;
            }
            $itemModel = null;
        }

        $propertyAccessor->setValue(
            $this,
            $mappingOption->property,
            $itemModel,
        );
    }

    private function buildCollectionOption(
        Collection $mappingOption,
        mixed $modelData,
    ): void {
        $propertyAccessor = $this->getPropertyAccessor();

        $propertyData = $this->getValueOrNull($modelData, $mappingOption->path);

        if ($propertyData === null) {
            return;
        }

        $modelClass = $mappingOption->modelClass;

        $this->{$mappingOption->property} = [];

        foreach ($propertyData as $itemData) {
            $itemModel = new $modelClass($itemData);

            if ($mappingOption->indexBy !== null) {
                $indexValue = $this->getValueOrNull(
                    $itemModel,
                    $mappingOption->indexBy,
                );

                $this->{$mappingOption->property}[$indexValue] = $itemModel;
                continue;
            }

            $this->{$mappingOption->property}[] = $itemModel;
        }
    }

    private function buildPropertyCollectionOption(
        PropertyCollection $mappingOption,
        mixed $modelData,
    ): void {
        $propertyData = $this->getValueOrNull($modelData, $mappingOption->path);

        if ($propertyData === null) {
            return;
        }

        $this->{$mappingOption->property} = [];

        foreach ($propertyData as $itemData) {
            $data = $this->getValueOrNull($itemData, $mappingOption->subPath);
            $this->{$mappingOption->property}[] = $data;
        }
    }

    private function getValueOrNull(mixed $modelData, string $path)
    {
        $propertyAccessor = $this->getPropertyAccessor();

        try {
            $propertyData = $propertyAccessor->getValue($modelData, $path);
        } catch (\Symfony\Component\PropertyAccess\Exception\AccessException|\Symfony\Component\PropertyAccess\Exception\UnexpectedTypeException $exception) {
            $propertyData = null;
        }

        return $propertyData;
    }
}
