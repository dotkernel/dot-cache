<?php

declare(strict_types=1);

namespace DotTest\Cache;

use Dot\Cache\Adapter\ArrayAdapter;
use PHPUnit\Framework\TestCase;

class ArrayAdapterTest extends TestCase
{
    public function testStoresAndReadsItem(): void
    {
        $adapter = new ArrayAdapter();
        $adapter->save($adapter->getItem('key')->set('value'));

        $item = $adapter->getItem('key');

        $this->assertTrue($item->isHit());
        $this->assertSame('value', $item->get());
    }
}
