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
     * @Thing
     *
     * @return string
     */
    public function bar(): string
    {
        return 'test';
    }
}
