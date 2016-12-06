<?php

namespace Tests;

use Pgs\ElasticOM\ReflectionSingleton;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\ReflectionSingleton
 */
class ReflectionSingletonTest extends TestCase
{
    public function testGettingInstance()
    {
        $class = get_class(new class() {
        });

        $reflection = ReflectionSingleton::getInstance($class);

        $this->assertSame($class, $reflection->getName());
    }

    public function testSingleInstance()
    {
        $class = get_class(new class() {
        });

        $this->assertSame(
            ReflectionSingleton::getInstance($class),
            ReflectionSingleton::getInstance($class)
        );
    }
}
