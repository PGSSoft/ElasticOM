<?php

namespace Tests;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Pgs\ElasticOM\Adapter;
use Pgs\ElasticOM\EntityRepository;
use Pgs\ElasticOM\Exception;
use Pgs\ElasticOM\Hydrator\Hydrator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\EntityRepository
 */
class EntityRepositoryTest extends TestCase
{
    private $className;

    public function setUp()
    {
        AnnotationRegistry::registerLoader('class_exists');

        $this->className = get_class(new class() {
            /**
             * @Pgs\ElasticOM\Annotation\Id
             * @Pgs\ElasticOM\Annotation\Field(type="string")
             */
            private $first;

            /**
             * @Pgs\ElasticOM\Annotation\Field(type="string")
             */
            private $second;

            private $third;
        });
    }

    public function testFind()
    {
        $adapter = $this->createMock(Adapter::class);
        $adapter->expects($this->once())->method('find')->willReturn(['_id' => 1, '_source' => []]);

        $hydrator = $this->createMock(Hydrator::class);
        $hydrator->expects($this->once())->method('hydrate');

        $repository = new EntityRepository($adapter, $this->className, $hydrator);

        $this->assertInstanceOf($this->className, $repository->find('1'));
    }

    public function testFindMissing()
    {
        $adapter = $this->createMock(Adapter::class);
        $adapter->expects($this->once())->method('find')->willThrowException(new Missing404Exception());

        $hydrator = $this->createMock(Hydrator::class);

        $repository = new EntityRepository($adapter, $this->className, $hydrator);

        $this->expectException(Exception::class);

        $repository->find('404');
    }

    public function testFindBy()
    {
        $adapter = $this->createMock(Adapter::class);
        $adapter->expects($this->once())->method('findBy')->willReturn(['hits' => ['hits' => []]]);

        $hydrator = $this->createMock(Hydrator::class);

        $repository = new EntityRepository($adapter, $this->className, $hydrator);

        $this->assertInternalType(
            'array',
            $repository->findBy(
                ['name' => 'John Doe'],
                ['name' => 'asc'],
                10,
                20
            )
        );
    }

    public function testUpdate()
    {
        $adapter = $this->createMock(Adapter::class);
        $adapter->expects($this->once())->method('update')->willReturn(['_id' => 5]);

        $hydrator = $this->createMock(Hydrator::class);
        $hydrator->expects($this->once())->method('extract');
        $hydrator->expects($this->once())->method('getIdName')->willReturn('first');

        $repository = new EntityRepository($adapter, $this->className, $hydrator);

        $repository->update(new class() {
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
        });
    }
}
