<?php

namespace Tests\Annotation\Visitor;

use Pgs\ElasticOM\Annotation\Visitor\ClassMetadataVisitee;
use Pgs\ElasticOM\Annotation\Visitor\ClassMetadataVisiteeFactory;
use PHPUnit\Framework\TestCase;
use Tests\Annotation\Visitor\Mock\MockClass;

/**
 * @covers \Pgs\ElasticOM\Annotation\Visitor\ClassMetadataVisiteeFactory
 */
class ClassMetadataVisiteeFactoryTest extends TestCase
{
    public function testCreate()
    {
        $this->assertInstanceOf(
            ClassMetadataVisitee::class,
            ClassMetadataVisiteeFactory::create(MockClass::class)
        );
    }
}
