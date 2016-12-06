<?php

namespace Pgs\ElasticOM;

use Pgs\ElasticOM\Hydrator\HydratorFactory;

class EntityRepositoryManager
{
    /** @var array */
    private $repositories = [];

    /** @var Adapter */
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getRepository(string $entityName): EntityRepository
    {
        if (!isset($this->repositories[$entityName])) {
            $this->repositories[$entityName] = new EntityRepository(
                $this->adapter,
                $entityName,
                HydratorFactory::create()
            );
        }

        return $this->repositories[$entityName];
    }
}
