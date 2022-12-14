<?php

namespace App\Core\Payment;

use App\Core\Address\Address;
use App\Core\Document\Document;
use App\Enums\Payment\PaymentMethodEnum;
use App\Exceptions\Payment\BoletoTransactionNotCreatedException;
use App\Exceptions\Payment\PixTransactionNotCreatedException;
use App\Models\Customer as CustomerModel;
use App\Payment\Contracts\CreditCardResponseInterface;
use App\Payment\Contracts\PaymentServiceInterface;
use App\Payment\Contracts\TransactionResponseInterface;
use App\Payment\DTO\CreditCardDTO;
use App\Payment\DTO\TransactionDTO;
use App\Payment\PaymentGateways\Pagarme\Transaction\Billing;
use App\Payment\PaymentGateways\Pagarme\Transaction\Customer;
use App\Payment\PaymentGateways\Pagarme\Transaction\Items;
use App\Repositories\Purchase\PurchaseRepository;
use App\Repositories\Transaction\TransactionRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;

class Payment
{
    private PaymentServiceInterface $paymentService;

    public function __construct(
        private readonly PurchaseRepository    $purchaseRepository,
        private readonly TransactionRepository $transactionRepository,
    )
    {
        $this->paymentService = app(\App\Payment\Payment::class);
    }

    /**
     * @throws Exception
     */
    public function makeCreditCardTransaction(CustomerModel $customer, Fluent $data): TransactionResponseInterface
    {
        $transaction = $this->getTransaction($customer, $data);

        $transactionResponse = $this->paymentService->creditCard()->createSimpleTransaction($transaction);

        $this->saveTransaction($transactionResponse, $customer, $transaction);

        return $transactionResponse;
    }

    /**
     * @throws PixTransactionNotCreatedException
     */
    public function makePixTransaction(CustomerModel $customer, Fluent $data): TransactionResponseInterface
    {
        $transaction = $this->getTransaction($customer, $data);

        $transactionResponse = $this->paymentService->pix()->createTransaction($transaction);

        $this->saveTransaction($transactionResponse, $customer, $transaction);

        return $transactionResponse;
    }

    /**
     * @throws BoletoTransactionNotCreatedException
     * @throws Exception
     */
    public function makeBoletoTransaction(CustomerModel $customer, Fluent $data): TransactionResponseInterface
    {
        //TODO:: verificar com chave de produção se volta tudo certo o bar_code
        $transaction = $this->getTransaction($customer, $data);

        $transactionResponse = $this->paymentService->boleto()->createTransaction($transaction);

        $this->saveTransaction($transactionResponse, $customer, $transaction);

        return $transactionResponse;
    }

    /**
     * @throws Exception
     */
    private function getTransaction(CustomerModel $customer, Fluent $data): TransactionDTO
    {
        $document = new Document($data->customer['document_number']);

        $customerDTO = $this->getCustomer($customer, $document, $data);

        $card = $data->payment_method === PaymentMethodEnum::CREDITCARD->description()
            ? $this->getCreditCard($data)
            : null;

        $items = new Items($data->items);

        $billingAddress = $data->payment_method === PaymentMethodEnum::CREDITCARD->description()
            ? $this->getBillingAddress($data)
            : null;

        return new TransactionDTO(
            $items->getTotalPrice(),
            $data->payment_method,
            config('app.payment.providers.pagarme.postback'),
            $customerDTO,
            $items,
            $billingAddress,
            !empty($card) ? $card->getCardId() : null,
        );
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

    private function saveTransaction(TransactionResponseInterface $transactionResponse, CustomerModel $customer, TransactionDTO $transaction): void
    {
        DB::transaction(function () use ($transactionResponse, $customer, $transaction) {
            $transactionModel = $this->transactionRepository->store($customer, $transactionResponse);
            $this->purchaseRepository->store($transactionModel, $customer, $transaction->items());
        });
    }
}
