<?php

namespace Yiistack\Annotated\Tests;

use PHPUnit\Framework\TestCase;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\Finder\Finder;
use Yiistack\Annotated\AnnotatedClass;
use Yiistack\Annotated\AnnotatedMethod;
use Yiistack\Annotated\AnnotatedProperty;
use Yiistack\Annotated\AnnotationLoader;
use Yiistack\Annotated\Tests\Stub\AnnotatedObject;
use Yiistack\Annotated\Tests\Stub\Annotation\Assert;

class AnnotationLoaderTest extends TestCase
{

    public function testFindProperties()
    {
        $properties = $this->getAnnotationLoader()
            ->withTargets([AnnotatedObject::class])
            ->findProperties(Assert::class);

        $properties = iterator_to_array($properties);

        $this->assertCount(1, $properties);
        $this->assertContainsOnlyInstancesOf(AnnotatedProperty::class, $properties);
    }

    public function testFindClasses()
    {
        $classes = $this->getAnnotationLoader()
            ->withTargets([AnnotatedObject::class])
            ->findClasses(Assert::class);

        $classes = iterator_to_array($classes);

        $this->assertCount(1, $classes);
        $this->assertContainsOnlyInstancesOf(AnnotatedClass::class, $classes);
    }

    public function testFindMethods()
    {
        $methods = $this->getAnnotationLoader()
            ->withTargets([AnnotatedObject::class])
            ->findMethods(Assert::class);

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
