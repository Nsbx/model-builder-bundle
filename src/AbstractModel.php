<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder;

use ArrayObject;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

abstract class AbstractModel implements ModelInterface
{
    protected PropertyAccessorInterface $propertyAccessor;

    public function __construct(mixed $modelData)
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
            ->disableExceptionOnInvalidPropertyPath()
            ->disableExceptionOnInvalidIndex()
            ->getPropertyAccessor()
        ;

        $this->buildModel($modelData);
    }

    public function buildModel(\stdClass|array $modelData): void
    {
        foreach ($this->getMapping() as $propertyKey => $property) {
            if (!is_array($property)) {
                $propertyData = $this->propertyAccessor->getValue($modelData, $property);
                $this->propertyAccessor->setValue($this, $propertyKey, $propertyData);
            } else {
                try {
                    $propertyData = $this->propertyAccessor->getValue($modelData, $property['path']);
                } catch (\Exception $exception) {
                    $propertyData = null;
                }

                try {
                    if (array_key_exists('alternativePath', $property) && $propertyData === null) {
                        $propertyData = $this->propertyAccessor->getValue($modelData, $property['alternativePath']);
                    }
                } catch (\Exception $exception) {
                    $propertyData = null;
                }

                if ($propertyData === null) {
                    continue;
                }

                $isCollection = false;
                if (array_key_exists('isCollection', $property)) {
                    $isCollection = $property['isCollection'];
                }

                if ($isCollection) {
                    $modelClass = $property['class'];

                    $this->{$propertyKey} = [];
                    foreach ($propertyData as $itemData) {
                        $itemModel = new $modelClass($itemData);
                        $this->{$propertyKey}[] = $itemModel;
                    }

                    continue;
                }
                $this->propertyAccessor->setValue($this, $propertyKey, $propertyData);
            }
        }
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        switch (true) {
            case str_contains($name, 'get'):
                $methodPath = str_replace('get', '', $name);
                $methodPath = strtolower($methodPath);
                return $this->propertyAccessor->getValue($this, $methodPath);
            case str_contains($name, 'set'):
                $methodPath = str_replace('set', '', $name);
                $methodPath = strtolower($methodPath);
                $this->propertyAccessor->setValue($this, $methodPath, current($arguments));
                break;
        }
    }
}
