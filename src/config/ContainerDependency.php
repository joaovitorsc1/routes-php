<?php

declare(strict_types=1);

namespace Project\Routesphp\Config;

use ReflectionClass;

class ContainerDependency
{
    public static function get(string|object $className)
    {
        $reflaction = new ReflectionClass($className);
        $constructor = $reflaction->getConstructor();
        if($constructor === null) 
        {
            return new $className;
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];
        foreach($parameters as $parameter)
        {
            $dependency = $parameter->getType()->getName();
            $dependencies[] = new $dependency;
        }

        return $reflaction->newInstanceArgs($dependencies);
    }
}
?>