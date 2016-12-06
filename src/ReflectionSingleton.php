<?php

namespace Pgs\ElasticOM;

class ReflectionSingleton
{
    private static $instances = [];

    public static function getInstance(string $name): \ReflectionClass
    {
        if (!isset(self::$instances[$name])) {
            self::$instances[$name] = new \ReflectionClass($name);
        }

        return self::$instances[$name];
    }
}
