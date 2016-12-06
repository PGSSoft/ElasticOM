<?php

namespace Tests\Bridge\Symfony;

use Pgs\ElasticOM\Bridge\Symfony\ElasticOMExtension;
use Pgs\ElasticOM\Bridge\Symfony\ElasticOMBundle;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\Bridge\Symfony\ElasticOMBundle
 */
class ElasticOMBundleTest extends TestCase
{
    public function testGetContainerExtension()
    {
        $bundle = new ElasticOMBundle();

        $this->assertInstanceOf(ElasticOMExtension::class, $bundle->getContainerExtension());
    }
}
