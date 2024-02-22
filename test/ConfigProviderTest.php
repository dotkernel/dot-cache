<?php

declare(strict_types=1);

namespace DotTest\DotCache;

use Dot\Cache\Adapter\FilesystemAdapter;
use Dot\Cache\ConfigProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\FilesystemAdapter as SymfonyFilesystemAdapter;

class ConfigProviderTest extends TestCase
{
    protected array $config;

    protected function setup(): void
    {
        $this->config = (new ConfigProvider())();
    }

    public function testHasDependencies(): void
    {
        $this->assertArrayHasKey('dependencies', $this->config);
    }

    public function testDependenciesHasFactories(): void
    {
        $this->assertArrayHasKey('factories', $this->config['dependencies']);
        $this->assertArrayHasKey(FilesystemAdapter::class, $this->config['dependencies']['factories']);
    }

    public function testDependenciesHasAliases(): void
    {
        $this->assertArrayHasKey('aliases', $this->config['dependencies']);
        $this->assertArrayHasKey(SymfonyFilesystemAdapter::class, $this->config['dependencies']['aliases']);
    }
}
