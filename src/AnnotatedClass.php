<?php

declare(strict_types=1);

namespace Yiistack\Annotated;

use ReflectionClass;

final class AnnotatedClass
{
    private ReflectionClass $class;
    private object $annotation;

    public function __construct(ReflectionClass $class, object $annotation)
    {
        $this->class = $class;
        $this->annotation = $annotation;
    }

    public function getClass(): ReflectionClass
    {
        return $this->class;
    }

    public function getAnnotation(): object
    {
        return $this->annotation;
    }
}
