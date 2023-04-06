# Model Builder Bundle

## Summary

This bundle was created to ease the process of creating JSON objects from external API responses or any JSON that follows a specific model.

With this bundle, you can simply create a model and implement the abstract class "AbstractModelBuilder".

Once your model extends this class, you only need to implement the getMapping() function.

This function should return an array that describes how to map the JSON data to the model properties.

The mapping can describe simple properties, arrays of strings, or even sub models (collection or not).

The main functionality of this bundle is its ability to extract the correct JSON values from the provided paths. By having simple to describe our model.

The class also provides an implementation of the magic `__call` method, so you don't need to worry about implementing getter or setter.

The Bundle is easy to use and allows efficient processing of JSON data from an API. You can focus on the logic of your application rather than spending time writing code for handling and parsing JSON data from APIs.

Here is an example of a mapping array returned by the getMapping() function.

```php
public function getMapping(): array
{
    return [
        'id' => 'id',
        'name' => 'title',
        'url' => [
            'path' => 'test.url',
            'alternativePath' => 'url'
        ],
        'categories' => 'categories',
        'images' => [
            'path' => 'keyImages',
            'class' => ImageModel::class,
            'isCollection' => true,
        ],
        'price' => [
            'path' => 'price',
            'class' => PriceModel::class,
        ]
    ];
}

```

Here are the possible values:

```php
public function getMapping(): array
{
    return [
        '<PropertyName>' => '<Path>',
        '<PropertyName>' => [
            'path' => '<Path>', 
            'alternativePath' => '<Path>'
        ],
        '<PropertyName>' => [
            'path' => '<Path>', 
            'class' => <ModelClass>, 
            'isCollection' => <Boolean>
        ]
    ];
}
```

If you need more example, check the [Model](tests%2FModel) folder in the testing section. 

## Installation

``
composer require nsbx/model-builder-bundle
``
