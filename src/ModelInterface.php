<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder;

use Nsbx\Bundle\ModelBuilder\Mapping\Mapping;

interface ModelInterface
{
    public function getMapping(): Mapping;
}
