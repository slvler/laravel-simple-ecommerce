<?php

namespace App\Enums;

enum CartStatus
{
    case ACTIVE;
    case PASSIVE;

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::PASSIVE => 'Passive'
        };
    }
}
