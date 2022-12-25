<?php

namespace App\Services\Integrations\Payment\PaymentGateways\Pagarme\Contracts;

use App\Services\Integrations\Payment\DTO\CustomerDTO;
use App\Services\Integrations\Payment\PaymentGateways\Pagarme\Transaction\Billing;
use App\Services\Integrations\Payment\PaymentGateways\Pagarme\Transaction\Items;

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
