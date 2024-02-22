<?php

declare(strict_types=1);

namespace Dot\Cache;

use Dot\Cache\Adapter\FilesystemAdapter;
use Dot\Cache\Factory\FilesystemAdapterFactory;
use Symfony\Component\Cache\Adapter\FilesystemAdapter as SymfonyFilesystemAdapter;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependenciesConfig(),
        ];
    }

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
