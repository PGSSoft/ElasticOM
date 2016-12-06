<?php

namespace Tests;

use Pgs\ElasticOM\Exception;
use Pgs\ElasticOM\Extractor;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\Extractor
 */
class ExtractorTest extends TestCase
{
    public function testEntityWithNoId()
    {
        $this->expectException(Exception::class);

        (new Extractor())->getIdName(get_class(new class() {
            /**
             * @Pgs\ElasticOM\Annotation\Field(type="string")
             */
            public $first;
        }));
    }

    public function testGettingIdName()
    {
        $this->assertSame('first', (new Extractor())->getIdName(get_class(new class() {
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
        })));
    }

    public function testGettingFieldNames()
    {
        $this->assertSame(['first', 'second'], (new Extractor())->getFieldNames(get_class(new class() {
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
        })));
    }

    public function testEntityWithTwoIds()
    {
        $this->expectException(Exception::class);

        (new Extractor())->getIdName(get_class(new class() {
            /**
             * @Pgs\ElasticOM\Annotation\Id
             */
            public $first;

            /**
             * @Pgs\ElasticOM\Annotation\Id
             */
            public $second;
        }));
    }
}
