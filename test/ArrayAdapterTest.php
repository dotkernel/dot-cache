<?php

declare(strict_types=1);

namespace DotTest\DotCache;

use Dot\Cache\Adapter\ArrayAdapter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter as SymfonyArrayAdapter;

class ArrayAdapterTest extends TestCase
{
    public function testInstantiate()
    {
        $adapter = new ArrayAdapter();

        $this->assertInstanceOf(SymfonyArrayAdapter::class, $adapter);
    }
}
