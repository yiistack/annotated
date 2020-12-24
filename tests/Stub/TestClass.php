<?php

declare(strict_types=1);

namespace Yiistack\Annotated\Tests\Stub;

use Yiistack\Annotated\Tests\Stub\Annotation\Thing;

/**
 * @Thing
 */
final class TestClass
{
    /**
     * @Thing
     */
    public string $foo;

    /**
     * @return null
     * @Thing
     */
    public function bar()
    {
        return null;
    }
}
