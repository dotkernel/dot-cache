# Configuring the in-memory adapter

**The `array` adapter stores the cache in-memory.**

In ```config\autoload\doctrine.global.php``` you need to add the following configurations, under the ``doctrine`` key:

```php
'cache' => [
    'array' => [
        'class'     => \Dot\Cache\Adapter\ArrayAdapter::class,
    ],
],
```

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

