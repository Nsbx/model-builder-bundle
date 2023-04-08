# Model Builder Bundle

## Summary

This bundle was created to ease the process of creating JSON objects from external API responses or any JSON that follows a specific model.

With this bundle, you can simply create a model and implement the abstract class "AbstractModelBuilder".

Once your model extends this class, you only need to implement the getMapping() function.

This function should return an Mapping object that describes how to map the JSON data to the model properties.

The Bundle is easy to use and allows efficient processing of JSON data from an API. You can focus on the logic of your application rather than spending time writing code for handling and parsing JSON data from APIs.

If you need example, check the [Model](tests%2FModel) folder in the testing section. 

## Installation

``
composer require nsbx/model-builder-bundle
``
