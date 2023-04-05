<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder\Tests\Model;

use Nsbx\Bundle\ModelBuilder\AbstractModel;

/**
 * @method float getPrice()
 * @method string getCurrency()
 */
class PriceModel extends AbstractModel
{
    public string $price;
    public string $currency;

    public function getMapping(): array
    {
        return [
            'price'  => 'price',
            'currency' => 'currencySymbol',
        ];
    }
}
