<?php

declare(strict_types=1);

namespace Yiistack\Annotated\Tests\Stub;

use Yiistack\Annotated\Tests\Stub\Annotation\Thing;

/**
 * @Thing
 */
class TestClass
{
    /**
     * @Thing
     */
    public $foo;

    /**
     * @return null
     * @Thing
     */
    public function bar()
    {
        return null;
    }
}
