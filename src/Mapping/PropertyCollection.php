<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder\Mapping;

class PropertyCollection implements MappingOptionInterface
{
    public function __construct(
        public string $property,
        public string $path,
        public string $subPath
    ) {}

    public static function new(
        string $property,
        string $path,
        string $subPath
    ) {
        return new self($property, $path, $subPath);
    }
}
