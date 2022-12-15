<?php

namespace App\Repositories\Payer;

use App\Core\Payment\Pix\Bank;
use App\Core\Payment\Pix\Payer as PayerDTO;
use App\Models\Payer;
use App\Models\Transaction;

interface PayerRepository
{
    public function createByTransaction(Transaction $transaction, PayerDTO $payer, Bank $bank): Payer;
}
