<?php

namespace Pgs\ElasticOM\ElasticApi;

use Elasticsearch\ClientBuilder;
use Pgs\ElasticOM\JsonSerializer;

class ApiServiceFactory
{
    public static function create(string $host, string $port, string $index): ApiService
    {
        $client = ClientBuilder::create()
            ->setSerializer(new JsonSerializer())
            ->setHosts(["$host:$port"])
            ->build();

        $elasticApi = new ElasticApi($client);

        return new ApiService(
            $elasticApi,
            $index
        );
    }
}
