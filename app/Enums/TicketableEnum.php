<?php

namespace App\Enums;

enum TicketableEnum: string
{
    case VISIT = 'App\\Models\\Visit';
    case DOCTOR = 'App\\Models\\Doctor';
    case REPRESENTATIVE = 'App\\Models\\Representative';

    public static function fromName($name)
    {
        return constant("self::$name");
    }
}
