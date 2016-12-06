<?php

namespace Pgs\ElasticOM\Annotation\Visitor;

class AnnotationConfigVisitor extends AnnotationVisitor
{
    protected function filterPropertyConfig(array $config): array
    {
        return array_filter(
            $config,
            function ($key) {
                return !in_array($key, ['idField', 'targetClass'], true);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}
