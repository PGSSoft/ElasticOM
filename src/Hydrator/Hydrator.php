<?php

namespace Pgs\ElasticOM\Hydrator;

use Pgs\ElasticOM\Annotation\ClassMetadata;
use Pgs\ElasticOM\Extractor;
use Pgs\ElasticOM\ObjectPool;
use Pgs\ElasticOM\ReflectionSingleton;
use Zend\Hydrator\AbstractHydrator;
use Zend\Hydrator\Reflection;

class Hydrator
{
    /** @var Extractor */
    protected $extractor;

    /** @var AbstractHydrator */
    protected $hydrator;

    /** @var ObjectPool */
    protected $objectPool;

    public function __construct(Extractor $extractor, AbstractHydrator $hydrator, ObjectPool $objectPool)
    {
        $this->extractor = $extractor;
        $this->hydrator = $hydrator;
        $this->objectPool = $objectPool;
    }

    public function getIdName(string $entity): string
    {
        return $this->extractor->getIdName($entity);
    }

    public function hydrate(array $data, $object)
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException('Missing object to hydrate');
        }

        $class = get_class($object);

        $metadata = ClassMetadata::getRawConfig($class);
        $nested = array_filter($metadata, function ($item) {
            return array_key_exists('targetClass', $item);
        });

        $this->processNested($nested, $data);

        return $this->hydrator->hydrate(
            array_intersect_key(
                $data,
                array_flip($this->extractor->getFieldNames($class))
            ),
            $object
        );
    }

    protected function processNested(array $config, array &$data)
    {
        foreach (array_intersect_key($config, $data) as $field => $metadata) {
            $idField = array_keys(array_filter(
                $metadata['properties'],
                function ($item) {
                    return array_key_exists('idField', $item);
                }
            ));
            $idField = reset($idField);

            $data[$field] = $this->getObject($data[$field], $idField, $metadata['targetClass']);
        }
    }

    protected function getObject(array $data, string $idField, string $class)
    {
        $object = $this->objectPool->get($idField, $class);
        if (!$object) {
            $object = ReflectionSingleton::getInstance($class)->newInstanceWithoutConstructor();
            $this->hydrate($data, $object);
            $this->objectPool->add($idField, $object);
        }

        return $object;
    }

    public function extract($object, bool $rootLevel = true): array
    {
        $this->hydrator = new Reflection();
        $this->hydrator->addStrategy('*', new HydrationStrategy($this));
        if ($rootLevel) {
            $this->hydrator->addFilter('id', function ($property) use ($object) {
                return
                    in_array($property, $this->extractor->getFieldNames(get_class($object)), true)
                    && $property !== $this->extractor->getIdName(get_class($object));
            });
        }

        return $this->hydrator->extract($object);
    }
}
