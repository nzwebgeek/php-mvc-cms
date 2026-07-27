<?php

namespace App\Core;

use ReflectionClass;
use RuntimeException;

class Container
{

    private array $services = [];


    public function set(
        string $name,
        object $service
    ): void {

        $this->services[$name]=$service;
    }


    public function get(
        string $class
    ): object {


        if(isset($this->services[$class])) {

            return $this->services[$class];

        }


        $reflection = new ReflectionClass($class);


        if(!$reflection->isInstantiable()) {

            throw new RuntimeException(
                "Cannot create {$class}"
            );
        }


        $constructor=$reflection->getConstructor();


        if(!$constructor) {

            return new $class();
        }


        $dependencies=[];


        foreach($constructor->getParameters() as $parameter){

            $type=$parameter->getType();


            if(!$type){

                throw new RuntimeException(
                    "Cannot resolve dependency"
                );
            }


            $dependencies[]=$this->get(
                $type->getName()
            );
        }


        return $reflection->newInstanceArgs(
            $dependencies
        );
    }
}