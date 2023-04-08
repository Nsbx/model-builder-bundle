<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder\Mapping;

class Mapping
{
    /** @var MappingOptionInterface[] */
    private static array $mappingOptions;

    public static function new(...$mappingOptions): self
    {
        $instance = new self();

        foreach ($mappingOptions as $mappingOption) {
            if (!$mappingOption instanceof MappingOptionInterface) {
                throw new \Exception('Options should be of type MappingOptionInterface');
            }
        }

        $instance::$mappingOptions = $mappingOptions;

        return $instance;
    }

    /**
     * @return MappingOptionInterface[]
     */
    public function getMappingOptions(): array
    {
        return self::$mappingOptions;
    }

}
