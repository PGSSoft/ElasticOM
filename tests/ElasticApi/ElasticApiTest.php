<?php

namespace Tests\ElasticApi;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Elasticsearch\Client;
use Elasticsearch\Namespaces\IndicesNamespace;
use Pgs\ElasticOM\ElasticApi\ElasticApi;
use PHPUnit\Framework\TestCase;
use Tests\Annotation\Visitor\Mock\MockClass;

/**
 * @covers \Pgs\ElasticOM\ElasticApi\ElasticApi
 */
class ElasticApiTest extends TestCase
{
    public function testCreateIndex()
    {
        $indicesMock = $this->createMock(IndicesNamespace::class);
        $indicesMock
            ->expects($this->once())
            ->method('create');

        $elasticApi = new ElasticApi($this->getClientMock($indicesMock));
        $elasticApi->createIndex('index');
    }

    public function testReindex()
    {
        $clientMock = $this->createMock(Client::class);
        $clientMock
            ->expects($this->once())
            ->method('reindex')
            ->with([
                'refresh' => true,
                'body' => [
                    'source' => [
                        'index' => 'index',
                    ],
                    'dest' => [
                        'index' => 'tmpindex',
                    ],
                ],
            ])
            ->willReturn([]);

        $elasticApi = new ElasticApi($clientMock);
        $elasticApi->reindex('index', 'tmpindex');
    }

    public function testRemoveIndex()
    {
        $indicesMock = $this->createMock(IndicesNamespace::class);
        $indicesMock
            ->expects($this->once())
            ->method('delete');

        $elasticApi = new ElasticApi($this->getClientMock($indicesMock));
        $elasticApi->removeIndex('index');
    }

    public function testCreateType()
    {
        AnnotationRegistry::registerLoader('class_exists');

        $indicesMock = $this->createMock(IndicesNamespace::class);
        $indicesMock
            ->expects($this->once())
            ->method('putMapping')
            ->with(
                [
                    'index' => 'index',
                    'type' => 'Tests\Annotation\Visitor\Mock\MockClass',
                    'body' => [
                        'Tests\Annotation\Visitor\Mock\MockClass' => [
                            'properties' => [
                                'property' => [
                                    'type' => 'string',
                                ],
                                'join' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'property' => [
                                            'type' => 'string',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]
            );

        $elasticApi = new ElasticApi($this->getClientMock($indicesMock));
        $elasticApi->createType('index', MockClass::class);
    }

    protected function getClientMock(IndicesNamespace $indicesMock)
    {
        $clientMock = $this->createMock(Client::class);
        $clientMock
            ->method('indices')
            ->willReturn($indicesMock);

        return $clientMock;
    }
}
