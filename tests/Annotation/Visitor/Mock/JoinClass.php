<?php

namespace Tests\Annotation\Visitor\Mock;

use Pgs\ElasticOM\Annotation as ODM;

class JoinClass
{
    /**
     * @ODM\Id()
     * @ODM\Field(type="string")
     */
    public $property;
}
