<?php

declare(strict_types=1);

namespace Yiistack\Annotated;

use Doctrine\Common\Annotations\AnnotationReader;
use Generator;
use ReflectionClass;
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
     * @psalm-return Generator<AnnotatedClass>
     *
     * @return AnnotatedClass[]|Generator
     */
    public function findClasses(string $annotation, ?ReflectionClass $class = null): Generator
    {
        if ($class !== null) {
            $annotations = $this->reader->getClassAnnotations($class);
            foreach ($annotations as $classAnnotation) {
                if ($classAnnotation instanceof $annotation) {
                    yield new AnnotatedClass($class, $classAnnotation);
                }
            }
        }
        foreach ($this->getTargets() as $target) {
            $annotations = $this->reader->getClassAnnotations($target);
            foreach ($annotations as $classAnnotation) {
                if ($classAnnotation instanceof $annotation) {
                    yield new AnnotatedClass($target, $classAnnotation);
                }
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
     * @psalm-return Generator<AnnotatedMethod>
     *
     * @return AnnotatedMethod[]|Generator
     */
    public function findMethods(string $annotation, ?ReflectionClass $class = null): Generator
    {
        if ($class !== null) {
            foreach ($class->getMethods() as $method) {
                $annotations = $this->reader->getMethodAnnotations($method);
                foreach ($annotations as $methodAnnotation) {
                    if ($methodAnnotation instanceof $annotation) {
                        yield new AnnotatedMethod($method, $methodAnnotation);
                    }
                }
            }
            return;
        }
        foreach ($this->getTargets() as $target) {
            foreach ($target->getMethods() as $method) {
                $annotations = $this->reader->getMethodAnnotations($method);
                foreach ($annotations as $methodAnnotation) {
                    if ($methodAnnotation instanceof $annotation) {
                        yield new AnnotatedMethod($method, $methodAnnotation);
                    }
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
     * @psalm-return Generator<AnnotatedProperty>
     *
     * @return AnnotatedProperty[]|Generator
     */
    public function findProperties(string $annotation, ?ReflectionClass $class = null): Generator
    {
        if ($class !== null) {
            foreach ($class->getProperties() as $property) {
                $annotations = $this->reader->getPropertyAnnotations($property);
                foreach ($annotations as $propertyAnnotation) {
                    if ($propertyAnnotation instanceof $annotation) {
                        yield new AnnotatedProperty($property, $propertyAnnotation);
                    }
                }
            }
            return;
        }
        foreach ($this->getTargets() as $target) {
            foreach ($target->getProperties() as $property) {
                $annotations = $this->reader->getPropertyAnnotations($property);
                foreach ($annotations as $propertyAnnotation) {
                    if ($propertyAnnotation instanceof $annotation) {
                        yield new AnnotatedProperty($property, $propertyAnnotation);
                    }
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
