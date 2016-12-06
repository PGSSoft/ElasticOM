<?php

namespace Pgs\ElasticOM\Annotation\Visitor;

use Doctrine\Common\Annotations\AnnotationReader;

class AnnotationVisitorFactory
{
    public static function getVisitor()
    {
        return new AnnotationVisitor(new AnnotationReader(), new ClassMetadataVisiteeFactory());
    }

    public static function getConfigVisitor()
    {
        return new AnnotationConfigVisitor(new AnnotationReader(), new ClassMetadataVisiteeFactory());
    }
}
