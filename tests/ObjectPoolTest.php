<?php

namespace Tests;

use Pgs\ElasticOM\ObjectPool;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\ObjectPool
 */
class ObjectPoolTest extends TestCase
{
    public function testAddGet()
    {
        $obj = new \stdClass();

        $pool = new ObjectPool();
        $pool->add('#id', $obj);

        $this->assertSame($pool->get('#id', \stdClass::class), $obj);
    }

    public function testGetNotExisting()
    {
        $pool = new ObjectPool();

        $this->assertSame($pool->get('#id', \stdClass::class), null);
    }
}
