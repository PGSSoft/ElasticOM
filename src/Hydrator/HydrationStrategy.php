<?php

namespace Pgs\ElasticOM\Hydrator;

use Zend\Hydrator\Strategy\StrategyInterface;

class HydrationStrategy implements StrategyInterface
{
    /** @var Hydrator */
    protected $hydrator;

    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function extract($value)
    {
        return is_object($value)
            ? $this->hydrator->extract($value, false)
            : $value;
    }

    public function hydrate($value)
    {
        return $value;
    }
}
