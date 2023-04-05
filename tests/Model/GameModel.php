<?php

declare(strict_types=1);

namespace Nsbx\Bundle\ModelBuilder\Tests\Model;

use ArrayObject;
use Nsbx\Bundle\ModelBuilder\AbstractModel;

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

    public function getMapping(): array
    {
        return [
            'id'         => 'id',
            'name'       => 'title',
            'url'        => [
                'path' => 'test.url',
                'alternativePath' => 'url'
            ],
            'categories' => 'categories',
            'images'         => [
                'path'         => 'keyImages',
                'class'        => ImageModel::class,
                'isCollection' => true,
            ],
            'price' => [
                'path'         => 'price',
                'class'        => PriceModel::class,
            ]
        ];
    }

    public function setPrice(mixed $data): void
    {
        $this->price = new PriceModel($data);
    }
}
