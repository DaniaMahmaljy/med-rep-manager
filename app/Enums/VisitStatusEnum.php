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

    public function label()
    {
        return match($this) {
            self::SCHEDULED => __('local.status.scheduled'),
            self::COMPLETED => __('local.status.completed'),
            self::CANCELED => __('local.status.canceled'),
            self::MISSED => __('local.status.missed'),
        };
    }

    public function color()
    {
        return match($this) {
            self::SCHEDULED => 'primary',
            self::COMPLETED => 'success',
            self::CANCELED => 'danger',
            self::MISSED => 'warning',
        };
    }
}
