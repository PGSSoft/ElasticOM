<?php

namespace Tests\Hydrator;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Pgs\ElasticOM\Extractor;
use Pgs\ElasticOM\Hydrator\Hydrator;
use Pgs\ElasticOM\ObjectPool;
use PHPUnit\Framework\TestCase;
use Tests\Annotation\Visitor\Mock\JoinClass;
use Tests\Annotation\Visitor\Mock\MockClass;
use Zend\Hydrator\Reflection;

/**
 * @covers \Pgs\ElasticOM\Hydrator\Hydrator
 */
class HydratorTest extends TestCase
{
    /* @var object */
    private $entity;

    /* @var Hydrator */
    private $hydrator;

    protected function setUp()
    {
        AnnotationRegistry::registerLoader('class_exists');

        $this->entity = new class() {
            /**
             * @Pgs\ElasticOM\Annotation\Id
             * @Pgs\ElasticOM\Annotation\Field(type="string")
             */
            public $first;

            /**
             * @Pgs\ElasticOM\Annotation\Field(type="string")
             */
            public $second;

            public $third;
        };

        $extractor = $this->createMock(Extractor::class);
        $extractor->method('getIdName')->willReturn('first');
        $extractor->method('getFieldNames')->willReturn(['first', 'second']);

        $this->hydrator = new Hydrator(
            $extractor,
            new Reflection(),
            $this->createMock(ObjectPool::class)
        );
    }

    public function testIdName()
    {
        $this->assertSame(
            'first',
            $this->hydrator->getIdName(get_class($this->entity))
        );
    }

    public function testHydratingNull()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->hydrator->hydrate([], null);
    }

    public function testHydrating()
    {
        $this->hydrator->hydrate(
            [
                'first' => 'Trying to change Id',
                'second' => 'Setting second',
                'third' => 'Not going anywhere',
            ],
            $this->entity
        );

        $this->assertSame('Trying to change Id', $this->entity->first);
        $this->assertSame('Setting second', $this->entity->second);

        // Property without annotation Filed shouldn't be hydrated
        $this->assertNotSame('Not going anywhere', $this->entity->third);
    }

    public function testHydratingNested()
    {
        $extractor = $this->createMock(Extractor::class);
        $extractor->method('getIdName')->willReturn('property');
        $extractor->method('getFieldNames')->willReturn(['property', 'join']);

        $hydrator = new Hydrator(
            $extractor,
            new Reflection(),
            $this->createMock(ObjectPool::class)
        );

        $entity = new MockClass();

        $hydrator->hydrate(
            [
                'property' => 'id',
                'join' => [
                    'property' => 'id',
                ],
            ],
            $entity
        );

        $this->assertSame('id', $entity->property);
        $this->assertInstanceOf(JoinClass::class, $entity->join);
        $this->assertSame('id', $entity->join->property);
    }

    public function testExtract()
    {
        $this->entity->first = 'first';
        $this->entity->second = 'second';
        $this->entity->third = 'third';

        // Only Field, but not Id should be extracted
        $this->assertSame(['second' => 'second'], $this->hydrator->extract($this->entity, true));
    }
}
