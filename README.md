# dot-cache

> [!IMPORTANT]
> dot-cache is a wrapper on top of [symfony/cache](https://github.com/symfony/cache)

## dot-cache badges

![OSS Lifecycle](https://img.shields.io/osslifecycle/dotkernel/dot-cache)
![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/dot-cache/4.2.0)

[![GitHub issues](https://img.shields.io/github/issues/dotkernel/dot-cache)](https://github.com/dotkernel/dot-cache/issues)
[![GitHub forks](https://img.shields.io/github/forks/dotkernel/dot-cache)](https://github.com/dotkernel/dot-cache/network)
[![GitHub stars](https://img.shields.io/github/stars/dotkernel/dot-cache)](https://github.com/dotkernel/dot-cache/stargazers)
[![GitHub license](https://img.shields.io/github/license/dotkernel/dot-cache)](https://github.com/dotkernel/dot-cache/blob/4.0/LICENSE.md)

[![Build Static](https://github.com/dotkernel/dot-cache/actions/workflows/continuous-integration.yml/badge.svg?branch=4.0)](https://github.com/dotkernel/dot-cache/actions/workflows/continuous-integration.yml)
[![codecov](https://codecov.io/gh/dotkernel/dot-cache/graph/badge.svg?token=FAN1MXKKS9)](https://codecov.io/gh/dotkernel/dot-cache)

> This package supports only `array` and `filesystem` adapters, you can use multiple adapters at once.

## Installation

Run the following command in your project directory

```shell
composer require dotkernel/dot-cache
```

After installing, add the `Dot\Cache\ConfigProvider::class` class to your configuration aggregate.

## Configuration for Doctrine in_array

In `config\autoload\doctrine.global.php` you need to add the following configurations:

Under the `doctrine.configuration.orm_default` key add the following config:

```php
'result_cache'       => 'array',
'metadata_cache'     => 'array',
'query_cache'        => 'array',
'hydration_cache'    => 'array',
'second_level_cache' => [
    'enabled'                    => true,
    'default_lifetime'           => 3600,
    'default_lock_lifetime'      => 60,
    'file_lock_region_directory' => '',
    'regions'                    => [],
],
```

Next, under the `doctrine` key add the following config:

```php
'cache' => [
    'array' => [
        'class' => \Dot\Cache\Adapter\ArrayAdapter::class,
    ],
],
```

> The above configuration will use an in-memory cache, because you use the `array` adapter.

If you want to store the cache into files on your local disk you will need to use the `filesystem` adapter.

## Configuration for Doctrine cache using filesystem

**The `filesystem` adapter needs some extra configurations:**

* directory (folder path)
* namespace (directory name)

```php
'cache' => [
    'array' => [
        'class'     => \Dot\Cache\Adapter\ArrayAdapter::class,
    ],
    'filesystem' => [
        'class'     => \Dot\Cache\Adapter\FilesystemAdapter::class,
        'directory' => getcwd() . '/data/cache',
        'namespace' => 'doctrine',
    ],
],
```

You can store `result_cache`, `metadata_cache`, `query_cache`, `hydration_cache` into files using the `filesystem` adapter, or you can store the `result_cache` into memory using the `array` adapter.

## Configuration example for both in-memory and filesystem adapters

Configuration sample for `config\autoload\doctrine.global.php` file:

```php
return [
    'dependencies'        => [
        'factories' => [
            \Dot\Cache\Adapter\FilesystemAdapter::class => \Dot\Cache\Factory\FilesystemAdapterFactory::class,
        'aliases'   => [
            \Symfony\Component\Cache\Adapter\FilesystemAdapter::class => \Dot\Cache\Adapter\FilesystemAdapter::class
        ],
    ],
    'doctrine'            => [
        'configuration' => [
            'orm_default' => [
                'result_cache'       => 'array',
                'metadata_cache'     => 'array',
                'query_cache'        => 'filesystem',
                'hydration_cache'    => 'array',
                'second_level_cache' => [
                    'enabled'                    => true,
                    'default_lifetime'           => 3600,
                    'default_lock_lifetime'      => 60,
                    'file_lock_region_directory' => '',
                    'regions'                    => [],
                ],
            ],
        ],
        'cache'      => [
            'array' => [
                'class'     => \Symfony\Component\Cache\Adapter\ArrayAdapter::class,
            ],
            'filesystem' => [
                'class'     => \Dot\Cache\Adapter\FilesystemAdapter::class,
                'directory' => getcwd() . '/data/cache',
                'namespace' => 'doctrine',
            ],
        ],
    ],
];
```

> The above configuration is just a sample, it should not be used as it is.

You can enable/disable the caching system using the `doctrine.configuration.orm_default.second_level_cache.enabled` key.
