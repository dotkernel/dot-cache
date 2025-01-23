# Configuring the filesystem adapter

**The `filesystem` adapter stores the cache on th hard disk and needs some extra configurations:**

- directory (folder path)
- namespace (directory name)

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
