<?php

declare(strict_types=1);

namespace Dot\Cache\Factory;

use Dot\Cache\Adapter\FilesystemAdapter;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class FilesystemAdapterFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): FilesystemAdapter
    {
        $config = $container->get('config')['doctrine']['cache']['filesystem'] ?? [];

        return new FilesystemAdapter(
            namespace: $config['namespace'] ?? '',
            defaultLifetime: $config['default_life_time'] ?? 0,
            directory: $config['directory'] ?? null,
            marshaller: $config['marshaller'] ?? null,
        );
    }
}
