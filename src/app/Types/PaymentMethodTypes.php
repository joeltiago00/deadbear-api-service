<?php

namespace App\Types;

abstract class PaymentMethodTypes
{
    const CREDIT_CARD = 'credit_card';
    const PIX = 'pix';
    const ALL = [self::CREDIT_CARD, self::PIX];
}
