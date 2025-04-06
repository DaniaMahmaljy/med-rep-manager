<?php

namespace App\Enums;

enum VisitStatusEnum: int
{
    case SCHEDULED = 1;
    case COMPLETED = 2;
    case CANCELED = 3;
    case MISSED = 4;

    public static function fromName($name)
    {
        return constant("self::$name");
    }
}
