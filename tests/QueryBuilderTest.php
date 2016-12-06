<?php

namespace Tests;

use Pgs\ElasticOM\Adapter;
use Pgs\ElasticOM\Hydrator\Hydrator;
use Pgs\ElasticOM\Query;
use Pgs\ElasticOM\QueryBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\QueryBuilder
 */
class QueryBuilderTest extends TestCase
{
    /** @var QueryBuilder */
    private $queryBuilder;

    protected function setUp()
    {
        $adapter = $this->createMock(Adapter::class);
        $hydrator = $this->createMock(Hydrator::class);

        $this->queryBuilder = new QueryBuilder($adapter, 'dummy', $hydrator);
    }

    public function testSettingMatch()
    {
        $this->queryBuilder
            ->setMatch('message', 'this is a test');

        $this->assertInstanceOf(Query::class, $this->queryBuilder->getQuery());
    }

    public function testSettingTerm()
    {
        $this->queryBuilder->setTerm('fieldOne', 42);

        $this->assertInstanceOf(Query::class, $this->queryBuilder->getQuery());
    }

    public function testSettingRange()
    {
        $this->queryBuilder->setRange('fieldOne', 42, 60);

        $this->assertInstanceOf(Query::class, $this->queryBuilder->getQuery());
    }

    public function testSettingMust()
    {
        $this->queryBuilder->setMust('fieldOne', 42);

        $this->assertInstanceOf(Query::class, $this->queryBuilder->getQuery());
    }

    public function testSettingFilter()
    {
        $this->queryBuilder->setFilter('fieldOne', 'valueOne');

        $this->assertInstanceOf(Query::class, $this->queryBuilder->getQuery());
    }

    public function testSettingMustNot()
    {
        $this->queryBuilder->setMustNot('fieldOne', 'value one');

        $this->assertInstanceOf(Query::class, $this->queryBuilder->getQuery());
    }

    public function testSettingShould()
    {
        $this->queryBuilder->setShould('fieldOne', 42);

        $this->assertInstanceOf(Query::class, $this->queryBuilder->getQuery());
    }

    public function testSettingOrderBy()
    {
        $this->queryBuilder->addOrderBy('fieldOne', 'asc')
            ->addOrderBy('fieldTwo');

        $this->assertInstanceOf(Query::class, $this->queryBuilder->getQuery());
    }

    public function testSettingGreaterThan()
    {
        $this->queryBuilder->addGreaterThan('fieldOne', 42);

        $this->assertInstanceOf(Query::class, $this->queryBuilder->getQuery());
    }

    public function testSettingLessThan()
    {
        $this->queryBuilder->addLessThan('fieldOne', 42);

        $this->assertInstanceOf(Query::class, $this->queryBuilder->getQuery());
    }

    public function testSettingFirstResult()
    {
        $this->queryBuilder->setFirstResult(10);

        $this->assertInstanceOf(Query::class, $this->queryBuilder->getQuery());
    }

    public function testSettingMaxResults()
    {
        $this->queryBuilder->setMaxResults(100);

        $this->assertInstanceOf(Query::class, $this->queryBuilder->getQuery());
    }
}
