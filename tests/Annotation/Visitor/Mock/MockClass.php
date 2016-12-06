<?php

namespace Tests\Annotation\Visitor\Mock;

use Pgs\ElasticOM\Annotation as ODM;

class MockClass
{
    /**
     * @ODM\Id()
     * @ODM\Field(type="string")
     */
    public $property;

    /**
     * @ODM\Field(type="object", targetClass="Tests\Annotation\Visitor\Mock\JoinClass")
     */
    public $join;
}
