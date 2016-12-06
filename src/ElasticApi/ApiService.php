<?php

namespace Pgs\ElasticOM\ElasticApi;

class ApiService
{
    /** @var ElasticApi */
    protected $elasticApi;

    /** @var string */
    protected $index;

    public function __construct(ElasticApi $elasticApi, string $index)
    {
        $this->elasticApi = $elasticApi;
        $this->index = $index;
    }

    public function createIndex()
    {
        $this->elasticApi->createIndex($this->index);
    }

    public function createType(string $type)
    {
        $this->elasticApi->createType($this->index, $type);
    }

    public function updateType(string $type)
    {
        $this->elasticApi->createIndex('tmp'.$this->index);
        $this->elasticApi->reindex($this->index, 'tmp'.$this->index);
        $this->elasticApi->removeIndex($this->index);
        $this->createIndex();
        $this->createType($type);
        $this->elasticApi->reindex('tmp'.$this->index, $this->index);
        $this->elasticApi->removeIndex('tmp'.$this->index);
    }
}
