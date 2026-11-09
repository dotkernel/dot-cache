# Changelog

## 5.0.0 - TBD

### Changed

- PHP requirement is now `~8.3.0 || ~8.4.0 || ~8.5.0 || ~8.6.0`
- `symfony/cache` requirement is now `^7.4 || ^8.1` (Symfony `8.0.x` is skipped)
- `FilesystemAdapterFactory` throws `Dot\Cache\Exception\InvalidConfigException` when `doctrine.cache.filesystem.directory` is missing, instead of silently caching in the system temp directory
- `FilesystemAdapterFactory` validates `namespace`, `default_lifetime` and `marshaller` and throws `InvalidConfigException` naming the key, instead of a PHP `TypeError`
- `ConfigProvider` and `FilesystemAdapterFactory` are now `final`
- PHPUnit `^12`, PHPStan level 8, PHPUnit fails on deprecations, notices, warnings and risky tests
- CI: GitHub Actions bumped to `actions/checkout@v7`, `actions/cache@v6`, `codecov/codecov-action@v7`

### Added

- Support for PHP 8.6
- Support for `symfony/cache` 8
- `default_lifetime` config key for the filesystem adapter
- `marshaller` config key accepts a container service name
- `Dot\Cache\Exception\InvalidConfigException`
- Explicit `psr/container` requirement
- `v5` documentation and the "Upgrading to 5.x" guide

### Deprecated

- `default_life_time` config key, use `default_lifetime`

### Removed

- Support for PHP 8.2
- Support for `symfony/cache` 7.0 to 7.3

### Fixed

- `default_lifetime` was silently ignored by `FilesystemAdapterFactory`
- `TypeError` when `default_lifetime` is a numeric string, or `marshaller` is a service name
- README configuration example did not parse
- Test namespace now matches the `autoload-dev` PSR-4 prefix (`DotTest\Cache`)

## 4.4.0 - 2025-10-30

### Changed

- Nothing

### Added

- Support for PHP 8.5

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 4.3.0 - 2025-02-28

### Changed

- Replaced Psalm with PHPStan

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 4.2.1 - 2025-01-27

### Changed

- Bumped Psalm to 6.x
- Codecov also runs on PHP 8.4

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 4.2.0 - 2025-01-23

### Changed

- `laminas/laminas-coding-standard` `^3.0`
- Documentation updates

### Added

- Support for PHP 8.4

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 4.1.0 - 2024-05-03

### Changed

- Documentation linting

### Added

- `mkdocs.yml` and the documentation site

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 4.0.0 - 2024-02-22

### Changed

- Replaced `laminas/laminas-cache` with `symfony/cache`; `3.x` is the last version that uses `laminas/laminas-cache`
- Removed support for PHP 8.1

### Added

- Support for PHP 8.3

### Deprecated

- Nothing

### Removed

- `laminas/laminas-cache`

### Fixed

- Nothing

## 3.1.3 - 2024-01-10

### Changed

- Updated dependencies

### Added

- Support for PHP 8.3

### Deprecated

- Nothing

### Removed

- Support for PHP 8.0

### Fixed

- Nothing

## 3.1.2 - 2023-08-18

### Changed

- PHPUnit `^10.3.2`
- `laminas/laminas-servicemanager` `^3.21.0`

### Added

- Support for PHP 8.2

### Deprecated

- Nothing

### Removed

- Support for PHP 7.4

### Fixed

- Nothing

## 3.1.1 - 2023-04-10

### Changed

- Nothing

### Added

- Suggests `phpfastcache/phpfastcache`

### Deprecated

- Package marked as abandoned

### Removed

- Nothing

### Fixed

- Nothing

## 3.1.0 - 2023-03-29

### Changed

- Replaced the `laminas/laminas-cache` requirement with the `laminas-cache` filesystem, session and memory storage adapters (still built on `laminas/laminas-cache`)

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- `laminas/laminas-dependency-plugin`

### Fixed

- Nothing

## 3.0.0 - 2022-04-06

### Changed

- PHP requirement is now `~7.4.0 || ~8.0.0 || ~8.1.0`
- `laminas/laminas-cache` `^3.1`, `laminas/laminas-servicemanager` `^3.10`
- PHPUnit `^9.5`

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 2.0.0 - 2020-01-30

### Changed

- Migrated from Zend Framework to Laminas and from Expressive to Mezzio
- PHP requirement is now `^7.2`

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 1.1.1 - 2018-05-03

### Changed

- Updated required dependencies

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 1.1.0 - 2017-03-15

### Changed

- Updated factories to use PSR-11 container

### Added

- Nothing

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 1.0.1 - 2017-03-10

### Added

- Updated PHP file header docblocks

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing

## 1.0.0 - 2017-03-08

Initial tagged release

### Added

- Everything

### Deprecated

- Nothing

### Removed

- Nothing

### Fixed

- Nothing
