<?php

namespace Pgs\ElasticOM;

use Elasticsearch\Common\Exceptions\Missing404Exception;
use Pgs\ElasticOM\Hydrator\Hydrator;

class EntityRepository
{
    /** @var Adapter */
    protected $adapter;

    /** @var string */
    protected $entityName;

    /** @var Hydrator */
    protected $hydrator;

    final public function __construct(Adapter $adapter, string $entityName, Hydrator $hydrator)
    {
        $this->adapter = $adapter;
        $this->entityName = $entityName;
        $this->hydrator = $hydrator;
    }

    public function find(string $id)
    {
        try {
            $data = $this->adapter->find($this->entityName, $id);
        } catch (Missing404Exception $e) {
            throw new Exception("$this->entityName with id '$id' not found");
        }

        $entity = ReflectionSingleton::getInstance($this->entityName)->newInstanceWithoutConstructor();

        $entityData = array_merge(
            $data['_source'],
            [
                $this->hydrator->getIdName($this->entityName) => $data['_id'],
            ]
        );

        $this->hydrator->hydrate($entityData, $entity);

        return $entity;
    }

    public function findBy(array $criteria, array $orderBy = [], int $limit = null, int $offset = null): array
    {
        $queryBuilder = $this->createQueryBuilder();

        foreach ($criteria as $key => $value) {
            $queryBuilder->setFilter($key, $value);
        }

        foreach ($orderBy as $key => $value) {
            $queryBuilder->addOrderBy($key, $value);
        }

        if ($limit !== null) {
            $queryBuilder->setMaxResults($limit);
        }

        if ($offset !== null) {
            $queryBuilder->setFirstResult($offset);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function update($entity)
    {
        $property = ReflectionSingleton::getInstance(get_class($entity))
            ->getProperty($this->hydrator->getIdName($this->entityName));
        $property->setAccessible(true);

        $response = $this->adapter->update(
            $this->entityName,
            $this->hydrator->extract($entity),
            $property->getValue($entity)
        );

        $property->setValue($entity, $response['_id']);
    }

    final protected function createQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder($this->adapter, $this->entityName, $this->hydrator);
    }
}
