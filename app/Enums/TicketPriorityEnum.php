<?php

namespace App\Enums;

enum TicketPriorityEnum: int
{
    case LOW = 1;
    case MEDIUM = 2;
    case HIGH = 3;

    public static function fromName($name)
    {
        return constant("self::$name");
    }
}
