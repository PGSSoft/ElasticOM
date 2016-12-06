<?php

namespace Pgs\ElasticOM\Bridge\ZF3;

class Module
{
    const CONFIG_KEY = 'elastic_om';

    public function getServiceConfig()
    {
        return [
            'factories' => [
                EntityRepositoryManager::class => EntityRepositoryManagerFactory::class,
            ],
            'aliases' => [
                'elastic_om.entity_repository_manager' => EntityRepositoryManager::class,
            ],
        ];
    }
}
