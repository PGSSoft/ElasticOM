<?php

namespace Tests\Hydrator;

use Pgs\ElasticOM\Hydrator\Hydrator;
use Pgs\ElasticOM\Hydrator\HydratorFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\Hydrator\HydratorFactory
 */
class HydratorFactoryTest extends TestCase
{
    public function testCreate()
    {
        $this->assertInstanceOf(
            Hydrator::class,
            HydratorFactory::create()
        );
    }
}
