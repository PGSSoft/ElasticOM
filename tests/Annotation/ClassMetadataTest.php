<?php

namespace Tests\Annotation;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Pgs\ElasticOM\Annotation\ClassMetadata;
use PHPUnit\Framework\TestCase;
use Tests\Annotation\Visitor\Mock\MockClass;

/**
 * @covers \Pgs\ElasticOM\Annotation\ClassMetadata
 */
class ClassMetadataTest extends TestCase
{
    public function testGetConfig()
    {
        AnnotationRegistry::registerLoader('class_exists');

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
            ClassMetadata::getConfig(MockClass::class)
        );
    }

    public function testGetRawConfig()
    {
        AnnotationRegistry::registerLoader('class_exists');

        $this->assertSame(
            [
                'property' => [
                    'idField' => true,
                    'type' => 'string',
                ],
                'join' => [
                    'type' => 'object',
                    'targetClass' => 'Tests\Annotation\Visitor\Mock\JoinClass',
                    'properties' => [
                        'property' => [
                            'idField' => true,
                            'type' => 'string',
                        ],
                    ],
                ],
            ],
            ClassMetadata::getRawConfig(MockClass::class)
        );
    }
}
