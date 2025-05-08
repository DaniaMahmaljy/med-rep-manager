<?php

namespace App\Enums;

enum NoteTypeEnum: int
{
    case REPORT = 1; //Made by Representative after visit
    case INSTRUCTION = 2; //Made by Supervisor

    public static function fromName($name)
    {
        return constant("self::$name");
    }

    public static function labels(): array
    {
        return [
            self::REPORT => __('local.Report'),
            self::INSTRUCTION => __('local.Instruction'),
        ];
    }

}
