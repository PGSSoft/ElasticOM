<?php

namespace Pgs\ElasticOM;

use Pgs\ElasticOM\Annotation\ClassMetadata;
use Pgs\ElasticOM\Annotation\Id;

class Extractor
{
    public function getIdName(string $entityClass): string
    {
        $ids = array_keys(array_filter(
            ClassMetadata::getRawConfig($entityClass),
            function (array $values) {
                return !empty($values[Id::KEY_NAME]);
            }
        ));

        if (count($ids) !== 1) {
            throw new Exception(sprintf(
                'No or more than one identifier specified for entity "%s". Every entity must have one identifier',
                $entityClass
            ));
        }

        return reset($ids);
    }

    public function getFieldNames(string $entityClass): array
    {
        return array_keys(ClassMetadata::getRawConfig($entityClass));
    }
}
