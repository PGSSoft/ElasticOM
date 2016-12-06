<?php

namespace Pgs\ElasticOM\Annotation;

abstract class BaseAnnotation
{
    /** @var array */
    protected $values;

    final public function __construct(array $rawValues)
    {
        $this->values = $rawValues;
    }

    public function getRawValues(): array
    {
        return $this->values;
    }
}
