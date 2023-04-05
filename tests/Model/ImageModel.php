<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder\Tests\Model;

use Nsbx\Bundle\ModelBuilder\AbstractModel;

/**
 * @method string getUrl()
 * @method string getType()
 */
class ImageModel extends AbstractModel
{
    public string $url;
    public string $type;

    public function getMapping(): array
    {
        return [
            'url'  => 'url',
            'type' => 'type',
        ];
    }
}
