<?php

declare(strict_types=1);

namespace Dot\Cache;

use Dot\Cache\Adapter\FilesystemAdapter;
use Dot\Cache\Factory\FilesystemAdapterFactory;
use Symfony\Component\Cache\Adapter\FilesystemAdapter as SymfonyFilesystemAdapter;

/**
 * @phpstan-type DependenciesConfig array{
 *     factories: array<class-string, class-string>,
 *     aliases: array<class-string, class-string>,
 * }
 */
final class ConfigProvider
{
    /**
     * @return array{dependencies: DependenciesConfig}
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependenciesConfig(),
        ];
    }

    /**
     * @return DependenciesConfig
     */
    public function getDependenciesConfig(): array
    {
        return [
            'factories' => [
                FilesystemAdapter::class => FilesystemAdapterFactory::class,
            ],
            'aliases'   => [
                SymfonyFilesystemAdapter::class => FilesystemAdapter::class,
            ],
        ];
    }
}
