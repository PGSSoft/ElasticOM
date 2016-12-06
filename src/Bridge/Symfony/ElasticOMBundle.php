<?php

namespace Pgs\ElasticOM\Bridge\Symfony;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ElasticOMBundle extends Bundle
{
    public function getContainerExtension(): ElasticOMExtension
    {
        return new ElasticOMExtension();
    }
}
