Thorr\Persistence
===

[![Latest Stable Version](https://poser.pugx.org/stefanotorresi/thorr-persistence/v/stable.png)](https://packagist.org/packages/stefanotorresi/thorr-persistence)
[![Latest Unstable Version](https://poser.pugx.org/stefanotorresi/thorr-persistence/v/unstable.png)](https://packagist.org/packages/stefanotorresi/thorr-persistence)
[![Build Status](https://travis-ci.org/stefanotorresi/thorr-persistence.png?branch=master)](https://travis-ci.org/stefanotorresi/thorr-persistence)
[![Code Coverage](https://scrutinizer-ci.com/g/stefanotorresi/thorr-persistence/badges/coverage.png?s=333719d623e594189d997672ca4c1852cf665a67)](https://scrutinizer-ci.com/g/stefanotorresi/thorr-persistence/)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/stefanotorresi/thorr-persistence/badges/quality-score.png?s=1a350e9ee86db7b9ec2d006675405292123f20cb)](https://scrutinizer-ci.com/g/stefanotorresi/thorr-persistence/)

Agnostic interfaces for a DataMapper implementation through vendor specific adapters.

## Implementations

* [Thorr\Persistence\Doctrine][thorr-persistence-doctrine] for [Doctrine ORM][doctrine-orm]

[thorr-persistence-doctrine]: http://github.com/stefanotorresi/thorr-persistence-doctrine
[doctrine-orm]: http://www.doctrine-project.org

## DataMapperManager usage

This library provides an optional Zend Framework 2 plugin manager for `DataMapperInterface` instances, the `DataMapperManager`.

It provides a method to retrieve data mappers for your entities: `DataMapperManager::getDataMapperForEntity($entity)`.

Here is an example:

```php
$config = [
    'entity_data_mapper_map' => [
        Entity::class => 'EntityDataMapperServiceName',
    ],
    'factories' => [
        'EntityDataMapperServiceName' => function () {
            // return a DataMapperInterface            
        },
    ],
];

$dataMapperManager = new DataMapperManager($config);

// retrieves the service configured as 'EntityDataMapperServiceName'
$entityMapper = $dataMapperManager->getDataMapperForEntity(Entity::class);
```

To use the `DataMapperManager` you have to require `zendframework/zend-servicemanager` via Composer:

```shell
composer require zendframework/zend-servicemanager
```

### Usage in a ZF2 module

When using the library as a Zend Framework 2 module, you can load the module `Thorr\Persistence` and implement 
`DataMapperManagerConfigProviderInterface` in your modules to provide the configuration via the 
`getDataMapperManagerConfig()` method.

The module will also register in the main `ServiceManager` a `DataMapperManager` instance with its FQCN, 
aliased with the `DataMapperManager` name, so you can retrieve it as follows:

```
$serviceManager->get(DataMapperManager::class);
// or
$serviceManager->get('DataMapperManager');
```
