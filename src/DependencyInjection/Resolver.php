<?php

namespace Gustavovinicius\Mkfig\DependencyInjection;

use ReflectionFunction;
use ReflectionClass;
use Exception;

class Resolver
{
    private $dependencies;

    public function method($method, array $dependencies = [])
    {
        $this->dependencies = $dependencies;

        $info = new ReflectionFunction($method);
        $parameters = $info->getParameters();
        $parameters = $this->resolveParameters($parameters);

        return call_user_func_array($info->getClosure(), $parameters);
    }

    public function class($class, array $dependencies = [])
    {
        $this->dependencies = $dependencies;

        $class = new ReflectionClass($class);

        if (!$class->isInstantiable()) {
            throw new Exception("{$class} Not instantiable");
        }

        $constructor = $class->getConstructor();

        if (!$constructor) {
            return new $class->name;
        }

        $parameters = $constructor->getParameters();
        $parameters = $this->resolveParameters($parameters);

        return $class->newInstanceArgs($parameters);
    }

    public function resolveParameters($parameters)
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();

            if ($dependency) {
                $dependencies[] = $this->class($dependency->name, $dependencies);
            } else {
                $dependencies[] = $this->getDependencies($parameter);
            }
        }

        return $dependencies;
    }

    private function getDependencies($parameter)
    {
        if (isset($this->dependencies[$parameter->name])) {
            return $this->dependencies[$parameter->name];
        }

        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        throw new Execption("{$parameter->name} does not have value");
    }
}
