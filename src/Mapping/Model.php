<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder\Mapping;

class Model implements MappingOptionInterface
{
    public function __construct(
        public string $property,
        public string $path,
        public string $modelClass
    ) {}

    public static function new(
        string $property,
        string $path,
        string $modelClass
    ) {
        return new self($property, $path, $modelClass);
    }
}
