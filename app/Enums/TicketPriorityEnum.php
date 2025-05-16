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

    public function label(): string
    {
        return match($this) {
            self::LOW =>  __('local.Low'),
            self::MEDIUM => __('local.Medium'),
            self::HIGH => __('local.High'),
        };
    }

     public function color()
    {
        return match($this) {
            self::LOW => 'primary',
            self::MEDIUM => 'success',
            self::HIGH => 'danger',
        };
    }
}
