<?php

declare(strict_types=1);

namespace Dot\Cache\Factory;

use Dot\Cache\Adapter\FilesystemAdapter;
use Dot\Cache\Exception\InvalidConfigException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Cache\Marshaller\MarshallerInterface;
use Traversable;

use function array_key_exists;
use function filter_var;
use function is_array;
use function is_int;
use function is_string;
use function iterator_to_array;

use const FILTER_VALIDATE_INT;

/**
 * Creates the filesystem adapter from the `doctrine.cache.filesystem` config entry.
 *
 * Supported keys: `directory` (required), `namespace`, `default_lifetime` and `marshaller`.
 * The legacy key `default_life_time` is still read, but is deprecated in favour of `default_lifetime`.
 */
final class FilesystemAdapterFactory
{
    private const CONFIG_KEY = 'doctrine.cache.filesystem';

    /**
     * @throws ContainerExceptionInterface
     * @throws InvalidConfigException
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): FilesystemAdapter
    {
        $config = $this->filesystemConfig($container);

        return new FilesystemAdapter(
            namespace: $this->namespace($config),
            defaultLifetime: $this->defaultLifetime($config),
            directory: $this->directory($config),
            marshaller: $this->marshaller($container, $config),
        );
    }

    /**
     * @return array<array-key, mixed>
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function filesystemConfig(ContainerInterface $container): array
    {
        $config = $container->has('config') ? $container->get('config') : [];
        if (! isset($config['doctrine']['cache']['filesystem'])) {
            return [];
        }

        $config = $config['doctrine']['cache']['filesystem'];
        if ($config instanceof Traversable) {
            $config = iterator_to_array($config);
        }

        if (! is_array($config)) {
            throw InvalidConfigException::notAnArray(self::CONFIG_KEY, $config);
        }

        return $config;
    }

    /**
     * @param array<array-key, mixed> $config
     */
    private function namespace(array $config): string
    {
        $namespace = $config['namespace'] ?? '';
        if (! is_string($namespace)) {
            throw InvalidConfigException::notAString(self::CONFIG_KEY . '.namespace', $namespace);
        }

        return $namespace;
    }

    /**
     * @param array<array-key, mixed> $config
     */
    private function defaultLifetime(array $config): int
    {
        $lifetime = array_key_exists('default_lifetime', $config)
            ? $config['default_lifetime']
            : $config['default_life_time'] ?? 0;

        $seconds = is_int($lifetime) || is_string($lifetime)
            ? filter_var($lifetime, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]])
            : false;
        if ($seconds === false) {
            throw InvalidConfigException::invalidLifetime(self::CONFIG_KEY . '.default_lifetime', $lifetime);
        }

        return $seconds;
    }

    /**
     * @param array<array-key, mixed> $config
     */
    private function directory(array $config): string
    {
        $directory = $config['directory'] ?? null;
        if (! is_string($directory) || $directory === '') {
            throw InvalidConfigException::missingDirectory(self::CONFIG_KEY . '.directory');
        }

        return $directory;
    }

    /**
     * @param array<array-key, mixed> $config
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function marshaller(ContainerInterface $container, array $config): ?MarshallerInterface
    {
        $marshaller = $config['marshaller'] ?? null;
        if (is_string($marshaller)) {
            $marshaller = $container->get($marshaller);
        }

        if ($marshaller !== null && ! $marshaller instanceof MarshallerInterface) {
            throw InvalidConfigException::invalidMarshaller(self::CONFIG_KEY . '.marshaller', $marshaller);
        }

        return $marshaller;
    }
}
