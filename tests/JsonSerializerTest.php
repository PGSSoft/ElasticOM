<?php

namespace Tests;

use Pgs\ElasticOM\JsonSerializer;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\JsonSerializer
 */
class JsonSerializerTest extends TestCase
{
    public function testSerialize()
    {
        $this->assertSame(
            '{"id":10,"name":"John"}',
            (new JsonSerializer())->serialize(['id' => 10, 'name' => 'John'])
        );
    }

    public function testCorrectJsonDeserialize()
    {
        $this->assertSame(
            ['id' => 10, 'name' => 'John'],
            (new JsonSerializer())->deserialize('{"id":10,"name":"John"}')
        );
    }
}
