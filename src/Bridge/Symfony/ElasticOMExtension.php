<?php

namespace Pgs\ElasticOM\Bridge\Symfony;

use Pgs\ElasticOM\Adapter;
use Pgs\ElasticOM\AdapterFactory;
use Pgs\ElasticOM\EntityRepositoryManager;
use Pgs\ElasticOM\ElasticApi\ApiService;
use Pgs\ElasticOM\ElasticApi\ApiServiceFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ElasticOMExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $arguments = array_intersect_key($config, array_flip(['host', 'port', 'index']));
        $serviceDefinition = new Definition(ApiService::class, $arguments);
        $serviceDefinition->setFactory([ApiServiceFactory::class, 'create']);

        $container->setDefinition('elastic_om.service', $serviceDefinition);

        $adapterDefinition = new Definition(Adapter::class, $arguments);
        $adapterDefinition->setFactory([AdapterFactory::class, 'create']);

        $container->setDefinition('elastic_om.adapter', $adapterDefinition)->setPublic(false);

        $repositoryDefinition = new Definition(
            EntityRepositoryManager::class,
            [new Reference('elastic_om.adapter')]
        );

        $container->setDefinition('elastic_om.entity_repository_manager', $repositoryDefinition);
    }
}
