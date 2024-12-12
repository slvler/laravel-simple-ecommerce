<?php

namespace App\Enums;

enum ProductStatus
{
    case DRAFT;
    case ACTIVE;
    case ARCHIVED;

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::ACTIVE => 'Active',
            self::ARCHIVED => 'Archived',
        };
    }
}
