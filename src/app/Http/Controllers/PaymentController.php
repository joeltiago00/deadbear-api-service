<?php

namespace App\Http\Controllers;

use App\Core\Payment\Payment;
use App\Exceptions\Payment\TransactionNotCreatedException;
use App\Http\Requests\PaymentRequest;
use Illuminate\Support\Fluent;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->payment = new Payment();
    }

    public function makeTransaction(PaymentRequest $request)
    {
        if (!$response =$this->payment->createSimpleCreditCardTransaction(new Fluent($request->validated())))
            throw new TransactionNotCreatedException();
    }
}
