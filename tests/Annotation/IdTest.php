<?php

namespace Tests\Annotation;

use Pgs\ElasticOM\Annotation\Id;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\Annotation\Id
 * @covers \Pgs\ElasticOM\Annotation\BaseAnnotation
 */
class IdTest extends TestCase
{
    public function testGetRawValues()
    {
        $id = new Id([]);
        $this->assertSame(['idField' => true], $id->getRawValues());
    }
}
