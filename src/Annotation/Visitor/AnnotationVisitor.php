<?php

namespace Pgs\ElasticOM\Annotation\Visitor;

use Doctrine\Common\Annotations\AnnotationReader;
use Pgs\ElasticOM\Annotation\BaseAnnotation;

class AnnotationVisitor
{
    /** @var AnnotationReader */
    protected $reader;

    /** @var ClassMetadataVisiteeFactory */
    protected $classMetadataFactory;

    public function __construct(AnnotationReader $reader, ClassMetadataVisiteeFactory $classMetadataFactory)
    {
        $this->reader = $reader;
        $this->classMetadataFactory = $classMetadataFactory;
    }

    public function visit(ClassMetadataVisitee $classMetadata)
    {
        $classConfig = [];
        foreach ($classMetadata->getClassReflection()->getProperties() as $property) {
            foreach ($this->reader->getPropertyAnnotations($property) as $annotation) {
                /* @var $annotation BaseAnnotation */
                if (!isset($classConfig[$property->getName()])) {
                    $classConfig[$property->getName()] = [];
                }

                $propertyConfig = $annotation->getRawValues();
                if (array_key_exists('targetClass', $propertyConfig)
                    && array_key_exists('type', $propertyConfig)
                    && in_array($propertyConfig['type'], ['object', 'nested'], true)
                ) {
                    $nestedClass = $this->classMetadataFactory->create($propertyConfig['targetClass']);
                    $propertyConfig['properties'] = $nestedClass->accept($this);
                }

                $classConfig[$property->getName()] = array_merge(
                    $classConfig[$property->getName()],
                    $this->filterPropertyConfig($propertyConfig)
                );
            }
        }

        return $classConfig;
    }

    protected function filterPropertyConfig(array $config): array
    {
        return $config;
    }
}
