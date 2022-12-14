<?php

namespace App\Payment\PaymentGateways\Pagarme\Contracts;

use App\Payment\PaymentGateways\Pagarme\Transaction\Billing;
use App\Payment\PaymentGateways\Pagarme\Transaction\Customer;
use App\Payment\PaymentGateways\Pagarme\Transaction\Items;
use App\Payment\PaymentGateways\Pagarme\Transaction\Shipping;

interface PagarmeTransactionInterface
{
    public function isDelivery(): bool;

    public function getAmount(): int;

    public function getCardId(): string;

    public function getPaymentMethod(): string;

    public function getPostbackUrl(): string;

    public function customer(): Customer;

    public function billing(): ?Billing;

    public function shipping(): ?Shipping;

    public function items(): Items;
}