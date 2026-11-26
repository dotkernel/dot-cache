# Configuring the filesystem adapter

**The `filesystem` adapter stores the cache on the hard disk.**

In `config\autoload\doctrine.global.php` you need to add the following configurations, under the `doctrine` key:

```php
'cache' => [
    'filesystem' => [
        'class'     => \Dot\Cache\Adapter\FilesystemAdapter::class,
        'directory' => getcwd() . '/data/cache',
        'namespace' => 'doctrine',
    ],
],
```

The factory reads its settings from the `doctrine.cache.filesystem` entry, so keep that name.

| Key | Required | Default | Description |
| --- | --- | --- | --- |
| `directory` | Yes | none | Path where cache files are stored |
| `namespace` | No | `''` | Sub-directory inside `directory` |
| `default_lifetime` | No | `0` | Lifetime of cache items in seconds; `0` means no expiry. Integer or numeric string |
| `marshaller` | No | Symfony's `DefaultMarshaller` | Service name or instance of `Symfony\Component\Cache\Marshaller\MarshallerInterface` |

> The key `default_life_time` is still read for backwards compatibility, but it is deprecated. Use `default_lifetime`.

If `directory` is missing or empty, or any key has the wrong type, the factory throws `Dot\Cache\Exception\InvalidConfigException` naming the key.

Under the `doctrine.configuration.orm_default` key add the following config:

```php
'result_cache'       => 'filesystem',
'metadata_cache'     => 'filesystem',
'query_cache'        => 'filesystem',
'hydration_cache'    => 'filesystem',
'second_level_cache' => [
    'enabled'                    => true,
    'default_lifetime'           => 3600,
    'default_lock_lifetime'      => 60,
    'file_lock_region_directory' => '',
    'regions'                    => [],
],
```
