<?php

namespace App\Services\Payment\Contracts;

use App\Exceptions\Payment\PixTransactionNotCreatedException;
use App\Services\Payment\DTO\TransactionDTO;

interface BoletoInterface
{
    /**
     * @throws PixTransactionNotCreatedException
     */
    public function createTransaction(TransactionDTO $transaction): TransactionResponseInterface;
}
