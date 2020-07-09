<?php

declare(strict_types=1);

namespace Yiistack\Annotated\Tests\Stub\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD", "PROPERTY"})
 */
class Assert
{
    public function __construct($values)
    {
    }
}
