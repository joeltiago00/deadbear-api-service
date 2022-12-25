<?php

namespace App\Services\Payment\Contracts;

use App\Exceptions\Payment\PixTransactionNotCreatedException;
use App\Services\Payment\DTO\TransactionDTO;

interface PixInterface
{
    /**
     * @throws PixTransactionNotCreatedException
     */
    public function createTransaction(TransactionDTO $transaction): TransactionResponseInterface;
}
