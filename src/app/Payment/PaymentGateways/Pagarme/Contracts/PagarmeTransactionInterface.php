<?php

namespace App\Payment\PaymentGateways\Pagarme\Contracts;

use App\Payment\DTO\CustomerDTO;
use App\Payment\PaymentGateways\Pagarme\Transaction\Billing;
use App\Payment\PaymentGateways\Pagarme\Transaction\Items;

interface PagarmeTransactionInterface
{
    public function getAmount(): int;

    public function getCardId(): ?string;

    public function getPaymentMethod(): string;

    public function getPostbackUrl(): string;

    public function customer(): CustomerDTO;

    public function billing(): ?Billing;

    public function items(): Items;
}
