<?php

namespace Pgs\ElasticOM\ElasticApi;

use Elasticsearch\Client;
use Pgs\ElasticOM\Annotation\Visitor\AnnotationVisitorFactory;
use Pgs\ElasticOM\Annotation\Visitor\ClassMetadataVisiteeFactory;

class ElasticApi
{
    /** @var Client */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function createIndex(string $index)
    {
        return $this->client->indices()->create([
            'index' => $index,
        ]);
    }

    public function reindex(string $source, string $destination): array
    {
        return $this->client->reindex([
            'refresh' => true,
            'body' => [
                'source' => [
                    'index' => $source,
                ],
                'dest' => [
                    'index' => $destination,
                ],
            ],
        ]);
    }

    public function removeIndex(string $index)
    {
        return $this->client->indices()->delete([
            'index' => $index,
        ]);
    }

    public function createType(string $index, string $entityClass)
    {
        $classMetadata = ClassMetadataVisiteeFactory::create($entityClass);
        $properties = $classMetadata->accept(AnnotationVisitorFactory::getConfigVisitor());

        $indexConfig = [
            'index' => $index,
            'type' => $entityClass,
            'body' => [
                $entityClass => [
                    'properties' => $properties,
                ],
            ],
        ];

        return $this->client->indices()->putMapping($indexConfig);
    }
}
