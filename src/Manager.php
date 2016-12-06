<?php

namespace Pgs\ElasticOM;

class Manager
{
    /** @var EntityRepositoryManager */
    private $objectRepositoryFactory;

    public function __construct(EntityRepositoryManager $objectRepositoryFactory)
    {
        $this->objectRepositoryFactory = $objectRepositoryFactory;
    }

    public function getRepository(string $className): EntityRepository
    {
        return $this->objectRepositoryFactory->getRepository($className);
    }
}
