<?php

namespace Pgs\ElasticOM\Bridge\ZF3;

use Pgs\ElasticOM\AdapterFactory;
use Pgs\ElasticOM\EntityRepositoryManager;
use Zend\ServiceManager\ServiceManager;

class EntityRepositoryManagerFactory
{
    public function __invoke(ServiceManager $sm)
    {
        $config = $sm->get('Config');

        $adapter = AdapterFactory::create(
            $config[Module::CONFIG_KEY]['host'] ?? 'localhost',
            $config[Module::CONFIG_KEY]['port'] ?? 9200,
            $config[Module::CONFIG_KEY]['index'] ?? 'elastic_om'
        );

        return new EntityRepositoryManager($adapter);
    }
}
