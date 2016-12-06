<?php

namespace Tests\Annotation\Visitor;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Pgs\ElasticOM\Annotation\Visitor\AnnotationVisitor;
use Pgs\ElasticOM\Annotation\Visitor\ClassMetadataVisitee;
use Pgs\ElasticOM\Annotation\Visitor\ClassMetadataVisiteeFactory;
use PHPUnit\Framework\TestCase;
use Tests\Annotation\Visitor\Mock\MockClass;

/**
 * @covers \Pgs\ElasticOM\Annotation\Visitor\AnnotationVisitor
 */
class AnnotationVisitorTest extends TestCase
{
    public function testVisit()
    {
        $classMetadataVisitee = new ClassMetadataVisitee(new \ReflectionClass(MockClass::class));

        AnnotationRegistry::registerLoader('class_exists');

        $visitor = new AnnotationVisitor(
            new AnnotationReader(),
            new ClassMetadataVisiteeFactory()
        );

        $this->assertSame(
            [
                'property' => [
                    'idField' => true,
                    'type' => 'string',
                ],
                'join' => [
                    'type' => 'object',
                    'targetClass' => 'Tests\Annotation\Visitor\Mock\JoinClass',
                    'properties' => [
                        'property' => [
                            'idField' => true,
                            'type' => 'string',
                        ],
                    ],
                ],
            ],
            $visitor->visit($classMetadataVisitee)
        );
    }
}
