<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder\Mapping;

class Collection implements MappingOptionInterface
{
    public function __construct(
        public string $property,
        public string $path,
        public string $modelClass,
        public ?string $indexBy,
    ) {}

    public static function new(
        string $property,
        string $path,
        string $modelClass,
        ?string $indexBy = null
    ) {
        return new self($property, $path, $modelClass, $indexBy);
    }
}
