<?php

namespace Tests\Bridge\ZF3;

use Pgs\ElasticOM\Bridge\ZF3\Module;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\Bridge\ZF3\Module
 */
class ModuleTest extends TestCase
{
    public function testInvoking()
    {
        $module = new Module();

        $config = $module->getServiceConfig();

        $this->assertInternalType('array', $config);
        $this->assertArrayHasKey('factories', $config);
        $this->assertArrayHasKey('aliases', $config);
    }
}
