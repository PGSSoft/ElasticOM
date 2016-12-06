<?php

namespace Pgs\ElasticOM;

class ObjectPool
{
    /** @var array */
    protected $pool = [];

    public function add(string $id, $object)
    {
        $this->pool[get_class($object)][$id] = $object;
    }

    /**
     * @return null|object
     */
    public function get(string $id, string $type)
    {
        return $this->pool[$type][$id] ?? null;
    }
}
