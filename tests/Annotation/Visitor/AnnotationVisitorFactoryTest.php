<?php

namespace Tests\Annotation\Visitor;

use Pgs\ElasticOM\Annotation\Visitor\AnnotationVisitor;
use Pgs\ElasticOM\Annotation\Visitor\AnnotationVisitorFactory;
use PHPUnit\Framework\TestCase;

class AnnotationVisitorFactoryTest extends TestCase
{
    public function testGetVisitor()
    {
        $this->assertInstanceOf(AnnotationVisitor::class, AnnotationVisitorFactory::getVisitor());
    }

    public function testGetConfigVisitor()
    {
        $this->assertInstanceOf(AnnotationVisitor::class, AnnotationVisitorFactory::getConfigVisitor());
    }
}
