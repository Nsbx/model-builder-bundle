<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder\Tests\Model;

use Nsbx\Bundle\ModelBuilder\AbstractModel;
use Nsbx\Bundle\ModelBuilder\Mapping\Collection;
use Nsbx\Bundle\ModelBuilder\Mapping\Mapping;
use Nsbx\Bundle\ModelBuilder\Mapping\Model;
use Nsbx\Bundle\ModelBuilder\Mapping\Property;
use Nsbx\Bundle\ModelBuilder\Mapping\PropertyCollection;

/**
 * @method int getId()
 * @method string getName()
 * @method string getUrl()
 * @method string[] getCategories()
 * @method ImageModel[] getImages()
 * @method PriceModel getPrice()
 */
class GameModel extends AbstractModel
{
    public int $id;
    public string $name;
    public string $url;
    public array $categories;
    public array $images;
    public PriceModel $price;
    public ?\DateTime $date;

    public function getMapping(): Mapping
    {
        return Mapping::new(
            Property::new('id', 'id'),
            Property::new('name', 'title'),
            Property::new('url', 'test.url', 'url'),
            Property::new('categories', 'categories'),
            Collection::new('images', 'keyImages', ImageModel::class, 'type'),
            Model::new('price', 'price', PriceModel::class),
            Model::new('date', 'date', \DateTime::class, true),
        );
    }
}
