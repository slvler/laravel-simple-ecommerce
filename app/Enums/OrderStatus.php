<?php

namespace App\Enums;

enum OrderStatus
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
