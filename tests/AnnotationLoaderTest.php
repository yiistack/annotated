<?php

declare(strict_types=1);

namespace Yiistack\Annotated\Tests;

use PHPUnit\Framework\TestCase;
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

    public function testFindProperties()
    {
        $properties = $this->getAnnotationLoader()
            ->withTargets([TestClass::class])
            ->findProperties(Thing::class);

        $properties = iterator_to_array($properties);

        $this->assertCount(1, $properties);
        $this->assertContainsOnlyInstancesOf(AnnotatedProperty::class, $properties);
    }

    public function testFindClasses()
    {
        $classes = $this->getAnnotationLoader()
            ->withTargets([TestClass::class])
            ->findClasses(Thing::class);

        $classes = iterator_to_array($classes);

        $this->assertCount(1, $classes);
        $this->assertContainsOnlyInstancesOf(AnnotatedClass::class, $classes);
    }

    public function testFindMethods()
    {
        $methods = $this->getAnnotationLoader()
            ->withTargets([TestClass::class])
            ->findMethods(Thing::class);

        $methods = iterator_to_array($methods);

        $this->assertCount(1, $methods);
        $this->assertContainsOnlyInstancesOf(AnnotatedMethod::class, $methods);
    }

    public function getAnnotationLoader()
    {
        $locator = new ClassLocator(Finder::create()->in(__DIR__ . '/Stub')->name('*.php'));

        return new AnnotationLoader($locator);
    }
}
