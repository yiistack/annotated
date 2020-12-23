<?php

declare(strict_types=1);

namespace Yiistack\Annotated;

use Doctrine\Common\Annotations\AnnotationReader;
use Generator;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Spiral\Tokenizer\ClassesInterface;

final class AnnotationLoader
{
    private ClassesInterface $classLocator;
    private AnnotationReader $reader;
    private array $targets = [];

    public function __construct(ClassesInterface $classLocator, AnnotationReader $reader = null)
    {
        $this->classLocator = $classLocator;
        $this->reader = $reader ?? new AnnotationReader();
    }

    public function withTargets(array $targets): self
    {
        $new = clone $this;
        $new->targets = $targets;

        return $new;
    }

    /**
     * Find all classes with given annotation.
     *
     * @param string $annotation
     *
     * @psalm-suppress ArgumentTypeCoercion
     * @psalm-return Generator
     *
     * @return ReflectionClass[]|Generator
     */
    public function findClasses(string $annotation): Generator
    {
        foreach ($this->getTargets() as $target) {
            $found = $this->reader->getClassAnnotation($target, $annotation);
            if ($found !== null) {
                yield new AnnotatedClass($target, $found);
            }
        }
    }

    /**
     * Find all methods with given annotation.
     *
     * @param string $annotation
     * @param ReflectionClass|null $class
     *
     * @psalm-suppress ArgumentTypeCoercion
     * @psalm-return Generator
     *
     * @return ReflectionMethod[]|Generator
     */
    public function findMethods(string $annotation, ?ReflectionClass $class = null): Generator
    {
        if ($class !== null) {
            foreach ($class->getMethods() as $method) {
                $found = $this->reader->getMethodAnnotation($method, $annotation);
                if ($found !== null) {
                    yield new AnnotatedMethod($method, $found);
                }
            }
            return;
        }
        foreach ($this->getTargets() as $target) {
            foreach ($target->getMethods() as $method) {
                $found = $this->reader->getMethodAnnotation($method, $annotation);
                if ($found !== null) {
                    yield new AnnotatedMethod($method, $found);
                }
            }
        }
    }

    /**
     * Find all properties with given annotation.
     *
     * @param string $annotation
     * @param ReflectionClass|null $class
     *
     * @psalm-suppress ArgumentTypeCoercion
     * @psalm-return Generator
     *
     * @return ReflectionProperty[]|Generator
     */
    public function findProperties(string $annotation, ?ReflectionClass $class = null): Generator
    {
        if ($class !== null) {
            foreach ($class->getProperties() as $property) {
                $found = $this->reader->getPropertyAnnotation($property, $annotation);
                if ($found !== null) {
                    yield new AnnotatedProperty($property, $found);
                }
            }
            return;
        }
        foreach ($this->getTargets() as $target) {
            foreach ($target->getProperties() as $property) {
                $found = $this->reader->getPropertyAnnotation($property, $annotation);
                if ($found !== null) {
                    yield new AnnotatedProperty($property, $found);
                }
            }
        }
    }

    private function getTargets(): Generator
    {
        if ($this->targets === []) {
            yield from $this->classLocator->getClasses();
            return;
        }

        foreach ($this->targets as $target) {
            yield from $this->classLocator->getClasses($target);
        }
    }
}
