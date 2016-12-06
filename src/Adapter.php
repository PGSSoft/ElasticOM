<?php

namespace Pgs\ElasticOM;

use Elasticsearch\Client;

class Adapter
{
    /** @var Client */
    private $client;

    /** @var string */
    private $index;

    public function __construct(Client $client, string $index)
    {
        $this->client = $client;
        $this->index = $index;
    }

    public function find(string $type, string $id): array
    {
        return $this->client->get([
            'index' => $this->index,
            'type' => $type,
            'id' => $id,
        ]);
    }

    public function findBy(string $type, array $body = []): array
    {
        return $this->client->search([
            'index' => $this->index,
            'type' => $type,
            'body' => $body,
        ]);
    }

    public function update(string $type, array $body, string $id = null): array
    {
        $params = [
            'index' => $this->index,
            'type' => $type,
            'refresh' => true,
            'body' => $body,
        ];

        if ($id !== null) {
            $params['id'] = $id;
        }

        return $this->client->index($params);
    }
}
