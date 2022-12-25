<?php

namespace App\Services\Integrations\Payment\Contracts;

use App\Exceptions\Payment\PixTransactionNotCreatedException;
use App\Services\Integrations\Payment\DTO\TransactionDTO;

interface PixInterface
{
    /**
     * @throws PixTransactionNotCreatedException
     */
    public function createTransaction(TransactionDTO $transaction): TransactionResponseInterface;
}
