<?php

namespace App\Enums;

enum PaymentStatusEnum: int
{
    case PENDING = 1;
    case APPROVED = 2;
    case DENIED = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Aprovado',
            self::DENIED => 'Denied',
            default => 'Unknown',
        };
    }
}