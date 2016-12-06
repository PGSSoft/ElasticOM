<?php

namespace Tests;

use Pgs\ElasticOM\Adapter;
use Pgs\ElasticOM\EntityRepository;
use Pgs\ElasticOM\EntityRepositoryManager;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\EntityRepositoryManager
 */
class EntityRepositoryManagerTest extends TestCase
{
    /** @var EntityRepositoryManager */
    private $manager;

    protected function setUp()
    {
        $this->manager = new EntityRepositoryManager($this->createMock(Adapter::class));
    }

    public function testGettingRepository()
    {
        $this->assertInstanceOf(
            EntityRepository::class,
            $this->manager->getRepository('DummyClass')
        );
    }

    public function testGettingRepositoryTwice()
    {
        $this->assertSame(
            $this->manager->getRepository('DummyClass'),
            $this->manager->getRepository('DummyClass')
        );
    }
}
