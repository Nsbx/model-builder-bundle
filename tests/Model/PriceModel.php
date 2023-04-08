<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder\Tests\Model;

use Nsbx\Bundle\ModelBuilder\AbstractModel;
use Nsbx\Bundle\ModelBuilder\Mapping\Mapping;
use Nsbx\Bundle\ModelBuilder\Mapping\Property;

/**
 * @method float getPrice()
 * @method string getCurrency()
 */
class PriceModel extends AbstractModel
{
    public string $price;
    public string $currency;

    public function getMapping(): Mapping
    {
        return Mapping::new(
            Property::new('price', 'price'),
            Property::new('currency', 'currencySymbol'),
        );
    }
}
