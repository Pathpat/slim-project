<?php

declare(strict_types=1);

namespace App\Enums;

enum InvoiceStatus: int
{
    case Pending = 0;
    case Paid = 1;
    case Void = 2;
    case Failed = 3;

    /**
     * Returns enum to a string
     * @return string
     */
    public function toString(): string
    {
        return match ($this) {
            self::Paid => 'Paid',
            self::Failed => 'Failed',
            self::Void => 'Void',
            default => 'Pending',
        };
    }
}
