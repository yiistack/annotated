<?php

declare(strict_types=1);

namespace Yiistack\Annotated;

use ReflectionClass;
use ReflectionProperty;

final class AnnotatedProperty
{
    private ReflectionProperty $property;
    private $annotation;

    public function __construct(ReflectionProperty $property, $annotation)
    {
        $this->property = $property;
        $this->annotation = $annotation;
    }

    public function getClass(): ReflectionClass
    {
        return $this->property->getDeclaringClass();
    }

    public function getAnnotation()
    {
        return $this->annotation;
    }
}
