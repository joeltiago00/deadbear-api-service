<?php

namespace App\Http\Controllers;

use App\Core\Payment\Payment;
use App\Exceptions\Payment\PixTransactionNotCreatedException;
use App\Exceptions\Payment\TransactionNotCreatedException;
use App\Http\Requests\PaymentRequest;
use App\Models\Customer;
use Illuminate\Support\Fluent;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function __construct(private readonly Payment $payment)
    {
    }

    /**
     * @throws \App\Exceptions\Transaction\TransactionFail
     * @throws TransactionNotCreatedException
     * @throws PixTransactionNotCreatedException
     */
    public function makeTransaction(PaymentRequest $request, Customer $customer)
    {
        if (!$response = $this->payment->makeBoletoTransaction($customer,new Fluent($request->validated())))
            throw new TransactionNotCreatedException();

        return response()->json($response->toArray(), Response::HTTP_OK);
    }
}
