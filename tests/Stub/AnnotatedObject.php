<?php

declare(strict_types=1);

namespace Yiistack\Annotated\Tests\Stub;

use Yiistack\Annotated\Tests\Stub\Annotation\Assert;

/**
 * Class AnnotatedObject
 * @package Yiistack\Annotated\Tests\Stub
 * @Assert
 */
class AnnotatedObject
{
    /**
     * @Assert
     */
    public $foo;

    /**
     * @return null
     * @Assert
     */
    public function bar()
    {
        return null;
    }
}
