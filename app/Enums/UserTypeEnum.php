<?php

namespace App\Enums;

enum UserTypeEnum: string
{
    case ADMIN = 'App\\Models\\Admin';
    case SUPERVISOR = 'App\\Models\\Supervisor';
    case REPRESENTATIVE = 'App\\Models\\Representative';

    public static function fromName($name)
    {
        return constant("self::$name");
    }

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Admin',
            self::SUPERVISOR => 'Supervisor',
            self::REPRESENTATIVE => 'Representative',
        };
    }

    public function role(): string
    {
        return strtolower($this->name);
    }

    public static function roleFromValue(string $value): ?string
    {
        $case = self::tryFrom($value);
        return $case?->role();
    }

}
