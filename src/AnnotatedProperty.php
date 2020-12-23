<?php

declare(strict_types=1);

namespace Yiistack\Annotated;

use ReflectionClass;
use ReflectionProperty;

final class AnnotatedProperty
{
    private ReflectionProperty $property;
    private object $annotation;

    public function __construct(ReflectionProperty $property, $annotation)
    {
        $this->property = $property;
        $this->annotation = $annotation;
    }

    public function getClass(): ReflectionClass
    {
        return $this->property->getDeclaringClass();
    }

    public function getProperty(): ReflectionProperty
    {
        return $this->property;
    }

    public function getAnnotation(): object
    {
        return $this->annotation;
    }
}
