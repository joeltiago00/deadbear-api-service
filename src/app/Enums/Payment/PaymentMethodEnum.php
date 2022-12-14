<?php

namespace App\Enums\Payment;

use App\Enums\Enum;

enum PaymentMethodEnum implements Enum
{
    case CREDITCARD;
    case PIX;
    case BOLETO;

    public function description(): string
    {
        return match ($this) {
            self::CREDITCARD => 'credit_card',
            self::PIX => 'pix',
            self::BOLETO => 'boleto'
        };
    }
}
