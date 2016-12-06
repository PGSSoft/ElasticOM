<?php

namespace Tests\ElasticApi;

use Pgs\ElasticOM\ElasticApi\ApiService;
use Pgs\ElasticOM\ElasticApi\ApiServiceAwareTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\ElasticApi\ApiServiceAwareTrait
 */
class ApiServiceAwareTraitTest extends TestCase
{
    public function testSetting()
    {
        $serviceAwareClass = new class() {
            use ApiServiceAwareTrait;
        };

        $service = $this->createMock(ApiService::class);

        $serviceAwareClass->setService($service);

        $this->assertInstanceOf(ApiService::class, $serviceAwareClass->getService());
    }
}
