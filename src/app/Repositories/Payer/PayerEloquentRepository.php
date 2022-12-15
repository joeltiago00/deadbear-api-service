<?php

namespace App\Repositories\Payer;

use App\Core\Payment\Pix\Bank;
use App\Core\Payment\Pix\Payer as PayerDTO;
use App\Models\Payer;
use App\Models\Transaction;
use App\Repositories\Repository;

class PayerEloquentRepository extends Repository implements PayerRepository
{
    public function __construct()
    {
        $this->setModel(Payer::class);
    }

    public function createByTransaction(Transaction $transaction, PayerDTO $payer, Bank $bank): Payer
    {
        return $transaction->payer()->create(array_merge($payer->toArray(), $bank->toArray()));
    }
}
