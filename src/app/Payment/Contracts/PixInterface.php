<?php

namespace App\Payment\Contracts;

use App\Exceptions\Payment\PixTransactionNotCreatedException;
use App\Payment\DTO\TransactionDTO;

interface PixInterface
{
    /**
     * @throws PixTransactionNotCreatedException
     */
    public function createTransaction(TransactionDTO $transaction): TransactionResponseInterface;
}
