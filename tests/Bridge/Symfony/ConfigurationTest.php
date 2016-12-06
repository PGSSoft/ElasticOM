<?php

namespace Tests\Bridge\Symfony;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Pgs\ElasticOM\Bridge\Symfony\Configuration;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Pgs\ElasticOM\Bridge\Symfony\Configuration
 */
class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    public function testDefaults()
    {
        $this->assertProcessedConfigurationEquals(
            [],
            [
                'host' => 'localhost',
                'port' => 9200,
                'index' => 'elastic_om',
            ]
        );
    }

    protected function getConfiguration()
    {
        return new Configuration();
    }
}
