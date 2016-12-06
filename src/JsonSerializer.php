<?php

namespace Pgs\ElasticOM;

use Elasticsearch\Serializers\SerializerInterface;

class JsonSerializer implements SerializerInterface
{
    public function serialize($data): string
    {
        return json_encode($data, JSON_PRESERVE_ZERO_FRACTION);
    }

    public function deserialize($data, $headers = null): array
    {
        return json_decode($data, true);
    }
}
