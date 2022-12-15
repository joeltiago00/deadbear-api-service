<?php

namespace App\Http\Controllers;

use App\Core\Payment\Payment;
use App\Enums\Payment\PaymentMethodEnum;
use App\Exceptions\Payment\BoletoTransactionNotCreatedException;
use App\Exceptions\Payment\PixTransactionNotCreatedException;
use App\Exceptions\Payment\TransactionNotCreatedException;
use App\Http\Requests\PaymentRequest;
use App\Services\Customer\CustomerService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Fluent;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function __construct(
        private readonly Payment $payment,
        private readonly CustomerService $customerService
    ) { }

    /**
     * @throws PixTransactionNotCreatedException
     * @throws BoletoTransactionNotCreatedException
     * @throws TransactionNotCreatedException
     * @throws Exception
     */
    public function makeTransaction(PaymentRequest $request): JsonResponse
    {
        $customer = $this->customerService->store($request->customer);

        if (!$response = match ($request->payment_method) {
            PaymentMethodEnum::CREDITCARD->description() => $this->payment->makeCreditCardTransaction($customer,new Fluent($request->validated())),
            PaymentMethodEnum::BOLETO->description() => $this->payment->makeBoletoTransaction($customer,new Fluent($request->validated())),
            PaymentMethodEnum::PIX->description() => $this->payment->makePixTransaction($customer,new Fluent($request->validated())),
            default => throw new Exception('Invalid payment method.')
        })
            throw new TransactionNotCreatedException();

        return response()->json($response->toArray(), Response::HTTP_OK);
    }
}
