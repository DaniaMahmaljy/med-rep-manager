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



        public function getUnitAttribute($value)
        {
            return SampleUnitEnum::from($value);
        }
    public function label(): string
    {
        return match($this) {
            self::PIECE =>  __('local.Piece'),
            self::BOX => __('local.Box'),
            self::BOTTLE => __('local.Bottle'),
            self::TUBE => __('local.Tube'),
            self::INJECTION => __('local.Injection'),
        };
    }

}
