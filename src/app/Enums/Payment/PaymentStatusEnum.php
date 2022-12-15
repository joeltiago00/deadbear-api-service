<?php

namespace App\Enums\Payment;

use App\Enums\Enum;

enum PaymentStatusEnum implements Enum
{
    case PAID;

    public function description(): string
    {
        return match ($this) {
            self::PAID => 'paid'
        };
    }
}
