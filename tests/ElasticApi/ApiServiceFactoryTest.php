<?php

namespace Tests\ElasticApi;

use Pgs\ElasticOM\ElasticApi\ApiService;
use Pgs\ElasticOM\ElasticApi\ApiServiceFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\ElasticApi\ApiServiceFactory
 */
class ApiServiceFactoryTest extends TestCase
{
    public function testGenerate()
    {
        $this->assertInstanceOf(ApiService::class, ApiServiceFactory::create('localhost', 9200, 'index'));
    }
}
