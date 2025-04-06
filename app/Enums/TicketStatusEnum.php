<?php

namespace App\Enums;

enum TicketStatusEnum: int
{
    case OPEN = 1;
    case IN_PROGRESS = 2;
    case RESOLVED = 3;
    case CLOSED = 4;

    public static function fromName($name)
    {
        return constant("self::$name");
    }
}
