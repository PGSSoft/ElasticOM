<?php

namespace Pgs\ElasticOM\Annotation;

/**
 * @Annotation
 */
class Id extends BaseAnnotation
{
    const KEY_NAME = 'idField';

    public function getRawValues(): array
    {
        return array_merge(
            [self::KEY_NAME => true],
            parent::getRawValues()
        );
    }
}
