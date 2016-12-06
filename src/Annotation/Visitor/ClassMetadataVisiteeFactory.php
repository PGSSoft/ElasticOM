<?php

namespace Pgs\ElasticOM\Annotation\Visitor;

use Pgs\ElasticOM\ReflectionSingleton;

class ClassMetadataVisiteeFactory
{
    public static function create(string $class): ClassMetadataVisitee
    {
        return new ClassMetadataVisitee(ReflectionSingleton::getInstance($class));
    }
}
