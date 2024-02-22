# dot-cache

DotKernel cache component based on symfony-cache.

![OSS Lifecycle](https://img.shields.io/osslifecycle/dotkernel/dot-cache)
![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/dot-cache/4.0)

[![GitHub issues](https://img.shields.io/github/issues/dotkernel/dot-cache)](https://github.com/dotkernel/dot-cache/issues)
[![GitHub forks](https://img.shields.io/github/forks/dotkernel/dot-cache)](https://github.com/dotkernel/dot-cache/network)
[![GitHub stars](https://img.shields.io/github/stars/dotkernel/dot-cache)](https://github.com/dotkernel/dot-cache/stargazers)
[![GitHub license](https://img.shields.io/github/license/dotkernel/dot-cache)](https://github.com/dotkernel/dot-cache/blob/4.0.0/LICENSE.md)

[![Build Static](https://github.com/dotkernel/dot-cache/actions/workflows/static-analysis.yml/badge.svg?branch=4.0)](https://github.com/dotkernel/dot-cache/actions/workflows/static-analysis.yml)
[![codecov](https://codecov.io/gh/dotkernel/dot-cache/graph/badge.svg?token=ZBZDEA3LY8)](https://codecov.io/gh/dotkernel/dot-cache)
[![SymfonyInsight](https://insight.symfony.com/projects/787c7526-eb9d-4fa2-a8d4-bfdcc008d239/big.svg)](https://insight.symfony.com/projects/787c7526-eb9d-4fa2-a8d4-bfdcc008d239)

## Installation

Run the following command in your project directory

    composer require dotkernel/dot-cache


After installing, add the `Dot\Cache\ConfigProvider::class` class to your configuration aggregate.

## Configuration

In ```config\autoload\doctrine.global.php``` you need to add the following configurations:

Under the ```doctrine.configuration.orm_default``` key add the following config:

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

Next, under the ```doctrine``` key add the following config:

```php
'cache' => [
    'array' => [
        'class'     => \Dot\Cache\Adapter\ArrayAdapter::class,
    ],
],
```

#### NOTE
The above configuration will use an in-memory cache, because you use the `array` adapter.

**This package supports only `array` and `filesystem` adapters and you can use multiple adapters at once.**

If you want to store the cache into files on your local disk you will need to use the `filesystem` adapter.

**The `filesystem` adapter needs some extra configurations :**
* directory (folder path)
* namespace (directory name)

```php
'cache' => [
    'array' => [
        'class'     => \Dot\Cache\Adapter\ArrayAdapter::class,
    ],
    'filesystem' => [
        'class'     => \Frontend\App\Common\FilesystemAdapter::class,
        'directory' => getcwd() . '/data/cache',
        'namespace' => 'test',
    ],
],
```

You can store `result_cache`, `metadata_cache`, `query_cache`, `hydration_cache` into files using the `filesystem`
adapter or you can store the `result_cache` into memory using the `array` adapter.

Configuration sample for ``config\autoload\doctrine.global.php`` file:

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
                'class'     => \Frontend\App\Common\FilesystemAdapter::class,
                'directory' => getcwd() . '/data/cache',
                'namespace' => 'doctrine',
            ],
        ],
    ],
];
```

### NOTE
**The above configuration is just a sample, it should not be used as it is.**

You can enable/disable the caching system using the `doctrine.configuration.orm_default.second_level_cache.enabled` key.



