<?php

namespace Tests;

use Pgs\ElasticOM\EntityRepository;
use Pgs\ElasticOM\EntityRepositoryManager;
use Pgs\ElasticOM\Manager;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\Manager
 */
class ManagerTest extends TestCase
{
    public function testGetRepository()
    {
        $objectRepositoryManager = $this->createMock(EntityRepositoryManager::class);
        $objectRepositoryManager->method('getRepository')->willReturn($this->createMock(EntityRepository::class));
        $manager = new Manager($objectRepositoryManager);

        $repository = $manager->getRepository('TheBundle:Entity');

        $this->assertInstanceOf(EntityRepository::class, $repository);
    }
}
