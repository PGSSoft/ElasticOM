<?php

namespace Tests;

use Pgs\ElasticOM\Adapter;
use Pgs\ElasticOM\Hydrator\Hydrator;
use Pgs\ElasticOM\Query;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\Query
 */
class QueryTest extends TestCase
{
    /** @var Query */
    private $query;

    protected function setUp()
    {
        $adapter = $this->createMock(Adapter::class);
        $hydrator = $this->createMock(Hydrator::class);
        $adapter->method('findBy')->willReturn(['hits' => ['hits' => [['_id' => 1, '_source' => []]]]]);

        $this->query = new Query(
            $adapter,
            get_class(new class() {
                /**
                 * @Pgs\ElasticOM\Annotation\Id
                 * @Pgs\ElasticOM\Annotation\Field(type="string")
                 */
                public $first;

                /**
                 * @Pgs\ElasticOM\Annotation\Field(type="string")
                 */
                public $second;

                public $third;
            }),
            [],
            $hydrator
        );
    }

    public function testReturningResults()
    {
        $this->assertInternalType('array', $this->query->getResult());
    }
}
