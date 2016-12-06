<?php

namespace Tests\Annotation\Visitor;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Pgs\ElasticOM\Annotation\Visitor\AnnotationConfigVisitor;
use Pgs\ElasticOM\Annotation\Visitor\ClassMetadataVisitee;
use Pgs\ElasticOM\Annotation\Visitor\ClassMetadataVisiteeFactory;
use PHPUnit\Framework\TestCase;
use Tests\Annotation\Visitor\Mock\MockClass;

/**
 * @covers \Pgs\ElasticOM\Annotation\Visitor\AnnotationConfigVisitor
 */
class AnnotationConfigVisitorTest extends TestCase
{
    public function testVisit()
    {
        $classMetadataVisitee = new ClassMetadataVisitee(new \ReflectionClass(MockClass::class));

        AnnotationRegistry::registerLoader('class_exists');

        $visitor = new AnnotationConfigVisitor(
            new AnnotationReader(),
            new ClassMetadataVisiteeFactory()
        );

        $this->assertSame(
            [
                'property' => [
                    'type' => 'string',
                ],
                'join' => [
                    'type' => 'object',
                    'properties' => [
                        'property' => [
                            'type' => 'string',
                        ],
                    ],
                ],
            ],
            $visitor->visit($classMetadataVisitee)
        );
    }
}
