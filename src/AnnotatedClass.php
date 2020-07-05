<?php

declare(strict_types=1);

namespace Yiistack\Annotated;

use ReflectionClass;

final class AnnotatedClass
{
    private ReflectionClass $class;
    private $annotation;

    public function __construct(ReflectionClass $class, $annotation)
    {
        $this->class = $class;
        $this->annotation = $annotation;
    }

    public function getClass(): ReflectionClass
    {
        return $this->class;
    }

    public function getAnnotation()
    {
        return $this->annotation;
    }
}
