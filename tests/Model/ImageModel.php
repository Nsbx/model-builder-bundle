<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder\Tests\Model;

use Nsbx\Bundle\ModelBuilder\AbstractModel;
use Nsbx\Bundle\ModelBuilder\Mapping\Mapping;
use Nsbx\Bundle\ModelBuilder\Mapping\Property;

/**
 * @method string getUrl()
 * @method string getType()
 */
class ImageModel extends AbstractModel
{
    public string $url;
    public string $type;

    public function getMapping(): Mapping
    {
        return Mapping::new(
            Property::new('type', 'type'),
            Property::new('url', 'url'),
        );
    }
}
