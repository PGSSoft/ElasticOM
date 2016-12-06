<?php

namespace Pgs\ElasticOM\Bridge\Symfony;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('elastic_om');

        $rootNode
            ->children()
                ->scalarNode('host')->defaultValue('localhost')->end()
                ->scalarNode('port')->defaultValue(9200)->end()
                ->scalarNode('index')->defaultValue('elastic_om')->end()
            ->end();

        return $treeBuilder;
    }
}
