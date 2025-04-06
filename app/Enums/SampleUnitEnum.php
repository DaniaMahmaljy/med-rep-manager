<?php

namespace App\Enums;

enum SampleUnitEnum: int
{
    case PIECE = 1;
    case BOX = 2;
    case BOTTLE = 3;
    case TUBE = 4;
    case INJECTION = 5;

    public static function fromName($name)
    {
        return constant("self::$name");
    }
}
