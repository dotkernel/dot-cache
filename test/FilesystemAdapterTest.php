<?php

declare(strict_types=1);

namespace DotTest\Cache;

use Dot\Cache\Adapter\FilesystemAdapter;
use DotTest\Cache\Fixture\TemporaryDirectory;
use PHPUnit\Framework\TestCase;

class FilesystemAdapterTest extends TestCase
{
    private TemporaryDirectory $directory;

    protected function setUp(): void
    {
        $this->directory = new TemporaryDirectory();
    }

    protected function tearDown(): void
    {
        $this->directory->remove();
    }

    public function testStoresItemOnDisk(): void
    {
        $adapter = new FilesystemAdapter('test', 0, $this->directory->path);
        $adapter->save($adapter->getItem('key')->set('value'));

        $reader = new FilesystemAdapter('test', 0, $this->directory->path);
        $item   = $reader->getItem('key');

        $this->assertTrue($item->isHit());
        $this->assertSame('value', $item->get());
    }
}
