<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class ModelBuilder
{
    private PropertyAccessorInterface $propertyAccessor;

    public function __construct()
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
            ->disableExceptionOnInvalidPropertyPath()
            ->disableExceptionOnInvalidIndex()
            ->getPropertyAccessor()
        ;
    }

    public function buildCollection(mixed $data, string $path, string $modelClass): array
    {
        $collection = [];

        $collectionData = $this->propertyAccessor->getValue($data, $path);

        foreach ($collectionData as $data) {
            $model = new $modelClass($data);
            $collection[] = $model;
        }

        return $collection;
    }
}
