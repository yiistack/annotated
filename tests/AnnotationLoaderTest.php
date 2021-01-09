<?php

declare(strict_types=1);

namespace Yiistack\Annotated\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\Finder\Finder;
use Yiistack\Annotated\AnnotatedClass;
use Yiistack\Annotated\AnnotatedMethod;
use Yiistack\Annotated\AnnotatedProperty;
use Yiistack\Annotated\AnnotationLoader;
use Yiistack\Annotated\Tests\Stub\TestClass;
use Yiistack\Annotated\Tests\Stub\Annotation\Thing;

class AnnotationLoaderTest extends TestCase
{

    public function testFindProperties(): void
    {
        $properties = $this->getAnnotationLoader()
            ->withTargets([TestClass::class])
            ->findProperties(Thing::class);

        $properties = iterator_to_array($properties);

        $this->assertCount(1, $properties);
        $this->assertContainsOnlyInstancesOf(AnnotatedProperty::class, $properties);
    }

    public function testFindPropertiesWithReflectionClass(): void
    {
        $properties = $this->getAnnotationLoader()
            ->findProperties(Thing::class, new ReflectionClass(TestClass::class));

        $properties = iterator_to_array($properties);

        $this->assertCount(1, $properties);
        $this->assertContainsOnlyInstancesOf(AnnotatedProperty::class, $properties);
    }

    public function testFindClasses(): void
    {
        $classes = $this->getAnnotationLoader()
            ->withTargets([TestClass::class])
            ->findClasses(Thing::class);

        $classes = iterator_to_array($classes);

        $this->assertCount(1, $classes);
        $this->assertContainsOnlyInstancesOf(AnnotatedClass::class, $classes);
    }

    public function testFindMethods(): void
    {
        $methods = $this->getAnnotationLoader()
            ->withTargets([TestClass::class])
            ->findMethods(Thing::class);

        $methods = iterator_to_array($methods);

        $this->assertCount(2, $methods);
        $this->assertContainsOnlyInstancesOf(AnnotatedMethod::class, $methods);
    }

    public function testFindMethodsWithReflectionClass(): void
    {
        $methods = $this->getAnnotationLoader()
            ->findMethods(Thing::class, new ReflectionClass(TestClass::class));

        $methods = iterator_to_array($methods);

        $this->assertCount(2, $methods);
        $this->assertContainsOnlyInstancesOf(AnnotatedMethod::class, $methods);
    }

    public function getAnnotationLoader(): AnnotationLoader
    {
        $locator = new ClassLocator(Finder::create()->in(__DIR__ . '/Stub')->name('*.php'));

        return new AnnotationLoader($locator);
    }
}
