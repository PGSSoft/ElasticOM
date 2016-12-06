<?php

namespace Tests;

use Elasticsearch\Client;
use Pgs\ElasticOM\Adapter;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\Adapter
 */
class AdapterTest extends TestCase
{
    /** @var Adapter */
    private $adapter;

    protected function setUp()
    {
        $client = $this->createMock(Client::class);
        $client->method('search')->willReturn([]);
        $client->method('get')->willReturn([]);
        $client->method('index')->willReturn([]);

        $this->adapter = new Adapter($client, 'dummy-index');
    }

    public function testSearch()
    {
        $response = $this->adapter->findBy('entity');

        $this->assertInternalType('array', $response);
    }

    public function testGetById()
    {
        $response = $this->adapter->find('entity', 'AVa7PLfTMyLR93z4FSn6');

        $this->assertInternalType('array', $response);
    }

    public function testUpdate()
    {
        $response = $this->adapter->update('entity', [], 'someId');

        $this->assertInternalType('array', $response);
    }
}
