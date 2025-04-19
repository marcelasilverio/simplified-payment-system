<?php

namespace App\Enums;

enum UserTypeEnum: int
{
    case COMMON = 1;
    case MERCHANT = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::COMMON => 'Common user',
            self::MERCHANT => 'Merchant',
            default => 'Unknown',
        };
    }
}