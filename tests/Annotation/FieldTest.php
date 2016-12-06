<?php

namespace Tests\Annotation;

use Pgs\ElasticOM\Annotation\Field;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\Annotation\Field
 * @covers \Pgs\ElasticOM\Annotation\BaseAnnotation
 */
class FieldTest extends TestCase
{
    public function testGetRawValues()
    {
        $field = new Field(['type' => 'nested', 'targetClass' => 'Tests\Annotation\Mock\MockClass']);
        $this->assertSame(
            ['type' => 'nested', 'targetClass' => 'Tests\Annotation\Mock\MockClass'],
            $field->getRawValues()
        );
    }
}
