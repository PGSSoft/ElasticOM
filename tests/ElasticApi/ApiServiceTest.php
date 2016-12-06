<?php

namespace Tests\ElasticApi;

use Pgs\ElasticOM\ElasticApi\ElasticApi;
use Pgs\ElasticOM\ElasticApi\ApiService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\ElasticApi\ApiService
 */
class ApiServiceTest extends TestCase
{
    public function testCreateIndex()
    {
        $elasticApiMock = $this->createMock(ElasticApi::class);
        $elasticApiMock
            ->expects($this->once())
            ->method('createIndex');

        $service = new ApiService($elasticApiMock, 'index');
        $service->createIndex();
    }

    public function testCreateType()
    {
        $elasticApiMock = $this->createMock(ElasticApi::class);
        $elasticApiMock
            ->expects($this->once())
            ->method('createType')
            ->with($this->equalTo('index'), $this->equalTo('type'));

        $service = new ApiService($elasticApiMock, 'index');
        $service->createType('type');
    }

    public function testUpdateType()
    {
        $elasticApiMock = $this->createMock(ElasticApi::class);
        $elasticApiMock
            ->expects($this->exactly(2))
            ->method('reindex')
            ->withConsecutive(
                [$this->equalTo('index'), $this->equalTo('tmpindex')],
                [$this->equalTo('tmpindex'), $this->equalTo('index')]
            );
        $elasticApiMock
            ->expects($this->exactly(2))
            ->method('removeIndex')
            ->withConsecutive(
                [$this->equalTo('index')],
                [$this->equalTo('tmpindex')]
            );
        $elasticApiMock
            ->expects($this->exactly(2))
            ->method('createIndex')
            ->withConsecutive(
                [$this->equalTo('tmpindex')],
                [$this->equalTo('index')]
            );
        $elasticApiMock
            ->expects($this->once())
            ->method('createType');

        $service = new ApiService($elasticApiMock, 'index');
        $service->updateType('type');
    }
}
