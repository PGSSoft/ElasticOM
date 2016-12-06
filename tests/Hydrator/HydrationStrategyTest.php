<?php

namespace Tests\Hydrator;

use Pgs\ElasticOM\Hydrator\HydrationStrategy;
use Pgs\ElasticOM\Hydrator\Hydrator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\Hydrator\HydrationStrategy
 */
class HydrationStrategyTest extends TestCase
{
    public function testExtractScalsr()
    {
        $strategy = new HydrationStrategy($this->createMock(Hydrator::class));
        $this->assertSame(5, $strategy->extract(5));
    }

    public function testExtractObject()
    {
        $obj = new \stdClass();

        $hydrator = $this->createMock(Hydrator::class);
        $hydrator->expects($this->once())->method('extract')->with($obj, false)->willReturn([]);
        $strategy = new HydrationStrategy($hydrator);

        $this->assertSame([], $strategy->extract($obj));
    }

    public function testHydrate()
    {
        $strategy = new HydrationStrategy($this->createMock(Hydrator::class));
        $this->assertSame(5, $strategy->hydrate(5));
    }
}
