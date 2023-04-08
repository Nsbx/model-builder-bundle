<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder\Mapping;

class Property implements MappingOptionInterface
{
    public function __construct(
        public string $property,
        public string $path,
        public ?string $alternativePath
    ) {}

    public static function new(
        string $property,
        string $path,
        ?string $alternativePath = null
    ) {
        return new self($property, $path, $alternativePath);
    }
}
