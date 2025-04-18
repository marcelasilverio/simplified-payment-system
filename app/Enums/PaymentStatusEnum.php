<?php

enum PaymentStatusEnum: int
{
    case PENDING = 1;
    case COMPLETED = 2;
    case FAILED = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::COMPLETED => 'Completed',
            self::FAILED => 'Failed',
            default => 'Unknown',
        };
    }
}