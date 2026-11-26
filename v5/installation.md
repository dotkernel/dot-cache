# Installation

## Requirements

- PHP `8.3`, `8.4`, `8.5` or `8.6`
- [symfony/cache](https://github.com/symfony/cache) `7.4` or `8.1+`, installed automatically: Composer picks `8.x` on PHP 8.4 and newer, and `7.4` on PHP 8.3

## Install the package

Install `dotkernel/dot-cache` by executing the following Composer command:

```shell
composer require dotkernel/dot-cache
```

## Register the ConfigProvider

Add `Dot\Cache\ConfigProvider::class` to your configuration aggregator (usually `config/config.php`):

```php
Dot\Cache\ConfigProvider::class,
```

It registers the factory for `Dot\Cache\Adapter\FilesystemAdapter` and aliases Symfony's `FilesystemAdapter` to it.

Upgrading from `4.x`? Read [Upgrading to 5.x](upgrading.md).
