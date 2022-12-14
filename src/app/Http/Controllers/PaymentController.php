<?php

namespace App\Http\Controllers;

use App\Core\Payment\Payment;
use App\Exceptions\Payment\TransactionNotCreatedException;
use App\Http\Requests\PaymentRequest;
use App\Models\Customer;
use Illuminate\Support\Fluent;

class PaymentController extends Controller
{
    public function __construct(private readonly Payment $payment)
    {
    }

    /**
     * @throws \App\Exceptions\Transaction\TransactionFail
     * @throws TransactionNotCreatedException
     */
    public function makeTransaction(PaymentRequest $request, Customer $customer)
    {
        if (!$response = $this->payment->makeCreditCardTransaction($customer,new Fluent($request->validated())))
            throw new TransactionNotCreatedException();
    }
}
