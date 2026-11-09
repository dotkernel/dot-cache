<?php

declare(strict_types=1);

namespace DotTest\Cache;

use Dot\Cache\Adapter\FilesystemAdapter;
use Dot\Cache\ConfigProvider;
use Dot\Cache\Factory\FilesystemAdapterFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\FilesystemAdapter as SymfonyFilesystemAdapter;

class ConfigProviderTest extends TestCase
{
    public function testInvokeReturnsDependencies(): void
    {
        $provider = new ConfigProvider();

        $this->assertSame(['dependencies' => $provider->getDependenciesConfig()], $provider());
    }

    public function testDependenciesConfig(): void
    {
        $this->assertSame(
            [
                'factories' => [
                    FilesystemAdapter::class => FilesystemAdapterFactory::class,
                ],
                'aliases'   => [
                    SymfonyFilesystemAdapter::class => FilesystemAdapter::class,
                ],
            ],
            (new ConfigProvider())->getDependenciesConfig()
        );
    }
}
