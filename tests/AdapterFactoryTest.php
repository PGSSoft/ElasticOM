<?php

namespace Tests;

use Pgs\ElasticOM\Adapter;
use Pgs\ElasticOM\AdapterFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\AdapterFactory
 */
class AdapterFactoryTest extends TestCase
{
    public function testCreate()
    {
        $this->assertInstanceOf(
            Adapter::class,
            AdapterFactory::create('www.example.com', 80, 'dummy-index')
        );
    }
}
