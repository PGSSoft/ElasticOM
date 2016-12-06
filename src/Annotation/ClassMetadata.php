<?php

namespace Pgs\ElasticOM\Annotation;

use Pgs\ElasticOM\Annotation\Visitor\AnnotationVisitorFactory;
use Pgs\ElasticOM\Annotation\Visitor\ClassMetadataVisiteeFactory;

class ClassMetadata
{
    public static function getRawConfig(string $entityClass): array
    {
        $classMetadata = ClassMetadataVisiteeFactory::create($entityClass);

        return $classMetadata->accept(AnnotationVisitorFactory::getVisitor());
    }

    public static function getConfig(string $entityClass): array
    {
        $classMetadata = ClassMetadataVisiteeFactory::create($entityClass);

        return $classMetadata->accept(AnnotationVisitorFactory::getConfigVisitor());
    }
}
