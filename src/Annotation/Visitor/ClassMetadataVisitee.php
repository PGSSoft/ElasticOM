<?php

namespace Pgs\ElasticOM\Annotation\Visitor;

class ClassMetadataVisitee
{
    /** @var \ReflectionClass */
    protected $class;

    public function __construct(\ReflectionClass $class)
    {
        $this->class = $class;
    }

    public function accept(AnnotationVisitor $visitor)
    {
        return $visitor->visit($this);
    }

    public function getClassReflection(): \ReflectionClass
    {
        return $this->class;
    }
}
