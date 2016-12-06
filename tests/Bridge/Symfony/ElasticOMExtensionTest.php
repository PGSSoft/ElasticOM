<?php

namespace Tests\Bridge\Symfony;

use Pgs\ElasticOM\Bridge\Symfony\ElasticOMExtension;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @covers \Pgs\ElasticOM\Bridge\Symfony\ElasticOMExtension
 */
class ElasticOMExtensionTest extends TestCase
{
    public function testLoading()
    {
        $container = $this->prophesize(ContainerBuilder::class);
        $container->setDefinition('elastic_om.service', Argument::type(Definition::class))
            ->shouldBeCalledTimes(1);
        $container->setDefinition('elastic_om.adapter', Argument::type(Definition::class))
            ->shouldBeCalledTimes(1)
            ->willReturn($this->createMock(Definition::class));
        $container->setDefinition('elastic_om.entity_repository_manager', Argument::type(Definition::class))
            ->shouldBeCalledTimes(1);

        $extension = new ElasticOMExtension();

        $extension->load([], $container->reveal());
    }
}
