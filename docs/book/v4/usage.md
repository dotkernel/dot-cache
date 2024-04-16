
# Usage

Version `4.x` of `dot-cache` is the last version that uses [symfony/cache](https://github.com/symfony/cache) to store cached data.

Using cache when querying the database:

```php
    $queryBuilder->select('users')
                 ->from(User::class, 'users');
                 
    $result = $queryBuilder->setCacheable(true)
                           ->getQuery()
                           ->getResult();
```
