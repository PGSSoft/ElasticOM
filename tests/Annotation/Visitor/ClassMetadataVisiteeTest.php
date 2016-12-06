<?php

namespace Tests\Annotation\Visitor;

use Pgs\ElasticOM\Annotation\Visitor\AnnotationVisitor;
use Pgs\ElasticOM\Annotation\Visitor\ClassMetadataVisitee;
use PHPUnit\Framework\TestCase;
use Tests\Annotation\Visitor\Mock\MockClass;

class ClassMetadataVisiteeTest extends TestCase
{
    public function testAccept()
    {
        $reflectionClass = new \ReflectionClass(MockClass::class);
        $classMetadataVisitee = new ClassMetadataVisitee($reflectionClass);

        $visitorMock = $this->createMock(AnnotationVisitor::class);
        $visitorMock
            ->expects($this->once())
            ->method('visit')
            ->willReturn([]);

        $this->assertSame([], $classMetadataVisitee->accept($visitorMock));
    }

    public function testGetReflectionClass()
    {
        $reflectionClass = new \ReflectionClass(MockClass::class);
        $classMetadataVisitee = new ClassMetadataVisitee($reflectionClass);

        $this->assertSame($reflectionClass, $classMetadataVisitee->getClassReflection());
    }
}
