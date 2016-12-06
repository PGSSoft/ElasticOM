<?php

namespace Pgs\ElasticOM;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Elasticsearch\ClientBuilder;

class AdapterFactory
{
    public static function create(string $host, int $port, string $index): Adapter
    {
        AnnotationRegistry::registerLoader('class_exists');

        return new Adapter(
            ClientBuilder::create()
                ->setSerializer(new JsonSerializer())
                ->setHosts(["$host:$port"])
                ->build(),
            $index
        );
    }
}
