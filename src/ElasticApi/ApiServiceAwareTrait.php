<?php

namespace Pgs\ElasticOM\ElasticApi;

trait ApiServiceAwareTrait
{
    /** @var ApiService */
    protected $service;

    public function getService(): ApiService
    {
        return $this->service;
    }

    public function setService(ApiService $service): self
    {
        $this->service = $service;

        return $this;
    }
}
