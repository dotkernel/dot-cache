<?php

declare(strict_types=1);

namespace DotTest\DotCache;

use Dot\Cache\Adapter\FilesystemAdapter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\FilesystemAdapter as SymfonyFilesystemAdapter;

class FilesystemAdapterTest extends TestCase
{
    public function testInstantiate()
    {
        $adapter = new FilesystemAdapter();

        $this->assertContainsOnlyInstancesOf(SymfonyFilesystemAdapter::class, [$adapter]);
    }
}
