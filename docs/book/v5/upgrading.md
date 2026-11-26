# Upgrading to 5.x

`dot-cache` 5.x still uses [symfony/cache](https://github.com/symfony/cache), like 4.x. Most applications only need to bump the version constraint and check their `doctrine.cache.filesystem` config.

```shell
composer require dotkernel/dot-cache:^5.0
```

## Changes that can break your code

| Change | Symptom | Fix |
| --- | --- | --- |
| PHP 8.2 support dropped | Composer refuses to install | Upgrade to PHP 8.3 or newer |
| `symfony/cache` 7.0 to 7.3 no longer allowed | Composer conflict with another package pinned to an old Symfony 7 minor | Update to Symfony 7.4, or 8.1+ on PHP 8.4+ |
| Symfony 8 is installed on PHP 8.4+ | `Error: Unknown named parameter $storeSerialized` when creating `ArrayAdapter` | Symfony 8 renamed the argument to `deepClone`. Use `deepClone:` or a positional argument |
| `directory` is now required for the filesystem adapter | `Dot\Cache\Exception\InvalidConfigException` while the container builds the adapter | Set `doctrine.cache.filesystem.directory`. In 4.x a missing directory silently stored the cache in the system temp directory |
| Config values are validated | `InvalidConfigException` instead of a PHP `TypeError` | Fix the key named in the message |
| `ConfigProvider` and `FilesystemAdapterFactory` are `final` | `Class ... cannot extend final class` | Wrap or decorate them instead of extending. The adapters are still not `final` |

## Changes in behaviour

| Change | Effect | What to do |
| --- | --- | --- |
| `default_lifetime` is now read | In 4.x only `default_life_time` worked, and `default_lifetime` was silently ignored | Use `default_lifetime`. If both are set, `default_lifetime` wins |
| `default_life_time` is deprecated | Still works in 5.x | Rename it to `default_lifetime` before 6.0 |
| Numeric strings are accepted for `default_lifetime` | `'3600'` (for example from an environment variable) now works | Nothing |
| `marshaller` can be a service name | It is fetched from the container | Nothing |

## Example

Before (4.x):

```php
'filesystem' => [
    'class'             => \Dot\Cache\Adapter\FilesystemAdapter::class,
    'namespace'         => 'doctrine',
    'default_life_time' => 3600,
],
```

After (5.x):

```php
'filesystem' => [
    'class'            => \Dot\Cache\Adapter\FilesystemAdapter::class,
    'directory'        => getcwd() . '/data/cache',
    'namespace'        => 'doctrine',
    'default_lifetime' => 3600,
],
```
