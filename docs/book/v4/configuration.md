# Configuration

After installation, register `dot-cache` package in your project by adding the below line to your configuration aggregator (usually: `config/config.php`):

```shell
Dot\Cache\ConfigProvider::class,
```

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

> The above configuration is just a sample and will use the in-memory adapter, it should be adapted to the app's needs.

> To disable the cache make sure the `enabled` key is `false`.

## Using both adapters at the same time

You can use both adapters at the same time, your configuration can look like this:

```php
'result_cache'       => 'filesystem',
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
```
