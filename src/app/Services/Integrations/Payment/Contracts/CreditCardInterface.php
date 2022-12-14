<?php

namespace App\Services\Integrations\Payment\Contracts;

use App\Services\Integrations\Payment\DTO\CreditCardDTO;
use App\Services\Integrations\Payment\PaymentGateways\Pagarme\Contracts\PagarmeTransactionInterface;

interface CreditCardInterface
{
    public function get(array $payload): CreditCardResponseInterface;

    public function createSimpleTransaction(PagarmeTransactionInterface $transaction): TransactionResponseInterface;

    public function createRecurrentTransaction(PagarmeTransactionInterface $transaction): TransactionResponseInterface;

    public function create(CreditCardDTO $card): CreditCardResponseInterface;
}
