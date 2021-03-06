<?php

declare(strict_types=1);

namespace Yiistack\Annotated;

use ReflectionClass;
use ReflectionMethod;

final class AnnotatedMethod
{
    private ReflectionMethod $method;
    private object $annotation;

    public function __construct(ReflectionMethod $method, object $annotation)
    {
        $this->method = $method;
        $this->annotation = $annotation;
    }

    public function getClass(): ReflectionClass
    {
        return $this->method->getDeclaringClass();
    }

    public function getMethod(): ReflectionMethod
    {
        return $this->method;
    }

    public function getAnnotation():object
    {
        return $this->annotation;
    }
}
