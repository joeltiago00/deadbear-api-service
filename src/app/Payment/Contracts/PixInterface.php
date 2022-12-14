<?php

namespace App\Payment\Contracts;

use App\Exceptions\Payment\PixTransactionNotCreatedException;
use App\Payment\DTO\TransactionDTO;

interface PixInterface
{
    /**
     * @throws PixTransactionNotCreatedException
     */
    public function makeTransaction(TransactionDTO $transaction): TransactionResponseInterface;
}
