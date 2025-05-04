<?php

namespace App\Enums;

enum SampleVisitStatus: int
{
    case PENDING = 1;
    case DELIVERED = 2;
    case RETURNED = 3;


    public static function fromName($name)
    {
        return constant("self::$name");
    }

      public function label()
    {
        return match($this) {
            self::PENDING => __('local.status.pending'),
            self::DELIVERED => __('local.status.delivered'),
            self::RETURNED => __('local.status.returned'),
        };
    }

      public function color()
    {
        return match($this) {
            self::PENDING => 'warning',
            self::DELIVERED => 'success',
            self::RETURNED => 'danger',
        };
    }
}
