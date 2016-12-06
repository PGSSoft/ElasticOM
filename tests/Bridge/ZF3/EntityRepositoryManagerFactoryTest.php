<?php

namespace Tests\Bridge\ZF3;

use Pgs\ElasticOM\Adapter;
use Pgs\ElasticOM\Bridge\ZF3\EntityRepositoryManagerFactory;
use Pgs\ElasticOM\EntityRepositoryManager;
use PHPUnit\Framework\TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers \Pgs\ElasticOM\Bridge\ZF3\EntityRepositoryManagerFactory
 */
class EntityRepositoryManagerFactoryTest extends TestCase
{
    public function testInvoking()
    {
        $serviceManager = $this->prophesize(ServiceManager::class);
        $serviceManager->get('Config')->willReturn([]);
        $serviceManager->get(Adapter::class)->willReturn($this->createMock(Adapter::class));
        $serviceManager = $serviceManager->reveal();

        $factory = new EntityRepositoryManagerFactory();

        $this->assertInstanceOf(EntityRepositoryManager::class, $factory($serviceManager));
    }
}
