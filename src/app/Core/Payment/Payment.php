<?php

namespace App\Core\Payment;

use App\Core\Address\Address;
use App\Core\Document\Document;
use App\Enums\Payment\PaymentMethodEnum;
use App\Models\Customer as CustomerModel;
use App\Payment\Contracts\CreditCardResponseInterface;
use App\Payment\Contracts\PaymentServiceInterface;
use App\Payment\DTO\CreditCardDTO;
use App\Payment\DTO\TransactionDTO;
use App\Payment\PaymentGateways\Pagarme\Transaction\Billing;
use App\Payment\PaymentGateways\Pagarme\Transaction\Customer;
use App\Payment\PaymentGateways\Pagarme\Transaction\Items;
use App\Repositories\Purchase\PurchaseRepository;
use App\Repositories\Transaction\TransactionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;

class Payment
{
    private PaymentServiceInterface $paymentService;

    public function __construct(
        private readonly PurchaseRepository $purchaseRepository,
        private readonly TransactionRepository $transactionRepository,
    )
    {
        $this->paymentService = app(\App\Payment\Payment::class);
    }

    /**
     * @throws \Exception
     */
    public function makeCreditCardTransaction(CustomerModel $customer, Fluent $data)
    {
        $document = new Document($data->customer['document_number']);

        $customerDTO = $this->getCustomer($customer, $document, $data);

        $card = $this->getCreditCard($data);

        $items = new Items($data->items);

        $billingAddress = $this->getBillingAddress($data);

        $transaction = new TransactionDTO(
            $items->getTotalPrice(),
            $card->getCardId(),
            PaymentMethodEnum::CREDITCARD->description(),
            '',
            $customerDTO,
            $items,
            $billingAddress
        );

        $transactionResponse = $this->paymentService->creditCard()->createSimpleTransaction($transaction);

        DB::transaction(function () use ($transactionResponse, $customer, $items) {
             $transactionModel = $this->transactionRepository->store($customer, $transactionResponse);
             $this->purchaseRepository->store($transactionModel, $customer, $items);
        });
    }

    private function getCreditCard(Fluent $data): CreditCardResponseInterface
    {
        return $this->paymentService->creditCard()->create(new CreditCardDTO(
            $data->card['holder_name'],
            $data->card['number'],
            $data->card['expiration_date'],
            $data->card['cvv'],
        ));
    }

    private function getCustomer(CustomerModel $user, Document $document, Fluent $data): Customer
    {
        return new Customer(
            $user->getKey(),
            $user->name,
            $user->email,
            'br',
            $document,
            $data->customer['phone_number']
        );
    }

    /**
     * @param Fluent $data
     * @return Billing
     */
    private function getBillingAddress(Fluent $data): Billing
    {
        $billingAddress = new Address(
            $data->billing['address']['street'],
            $data->billing['address']['number'],
            $data->billing['address']['neighborhood'],
            $data->billing['address']['zipcode'],
            $data->billing['address']['city'],
            $data->billing['address']['state'],
            $data->billing['address']['country'],
        );

        return new Billing($data->billing['name'], $billingAddress);
    }
}
