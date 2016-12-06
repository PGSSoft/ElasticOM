<?php

namespace Pgs\ElasticOM\Hydrator;

use Pgs\ElasticOM\Extractor;
use Pgs\ElasticOM\ObjectPool;
use Zend\Hydrator\Reflection;

class HydratorFactory extends Reflection
{
    public static function create(): Hydrator
    {
        return new Hydrator(
            new Extractor(),
            new Reflection(),
            new ObjectPool()
        );
    }
}
