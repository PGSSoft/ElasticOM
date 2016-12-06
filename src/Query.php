<?php

namespace Pgs\ElasticOM;

use Pgs\ElasticOM\Hydrator\Hydrator;

final class Query
{
    /** @var Adapter */
    private $adapter;

    /** @var array */
    private $body;

    /** @var string */
    private $entityName;

    /** @var Hydrator */
    private $hydrator;

    public function __construct(Adapter $adapter, string $entityName, array $body, Hydrator $hydrator)
    {
        $this->adapter = $adapter;
        $this->body = $body;
        $this->entityName = $entityName;
        $this->hydrator = $hydrator;
    }

    public function getResult(): array
    {
        return array_map(
            function (array $data) {
                $entity = ReflectionSingleton::getInstance($this->entityName)->newInstanceWithoutConstructor();
                $entityData = array_merge(
                    $data['_source'],
                    [
                        $this->hydrator->getIdName($this->entityName) => $data['_id'],
                    ]
                );

                $this->hydrator->hydrate($entityData, $entity);

                return $entity;
            },
            $this->adapter->findBy($this->entityName, $this->body)['hits']['hits']
        );
    }
}
