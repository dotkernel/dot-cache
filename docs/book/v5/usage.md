# Usage

> `dot-cache` uses [symfony/cache](https://github.com/symfony/cache) since version `4.0`.
> Version `3.x` of `dot-cache` is the last version that uses [laminas/laminas-cache](https://github.com/laminas/laminas-cache).

Using cache when querying the database:

```php
$queryBuilder->select('users')->from(User::class, 'users');

$result = $queryBuilder->setCacheable(true)->getQuery()->getResult();
```

> `setCacheable(true)` uses Doctrine's second-level cache, so `doctrine.configuration.orm_default.second_level_cache.enabled` must be `true`.
