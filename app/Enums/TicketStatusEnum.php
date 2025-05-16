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

    public function label(): string
    {
        return match($this) {
            self::OPEN =>  __('local.open'),
            self::IN_PROGRESS => __('local.In Progress'),
            self::RESOLVED => __('local.resolved'),
            self::CLOSED => __('local.closed'),
        };
    }

      public function color()
    {
        return match($this) {
            self::OPEN => 'primary',
            self::IN_PROGRESS => 'warning',
            self::RESOLVED => 'success',
            self::CLOSED => 'info',
        };
    }
}
