<?php

namespace App\Enums;

/**
 *
 */
enum OrderStatus: int
{
    case REQUESTED = 0;

    case APPROVED = 1;

    case CANCELED = 2;

    /**
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::REQUESTED => 'Requested',
            self::APPROVED => 'Approved',
            self::CANCELED => 'Canceled',
        };
    }
}
