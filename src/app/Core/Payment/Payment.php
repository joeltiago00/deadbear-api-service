<?php

namespace App\Core\Payment;

use App\Core\Address\Address;
use App\Core\Document\Document;
use App\Enums\Payment\PaymentMethodEnum;
use App\Exceptions\Payment\BoletoTransactionNotCreatedException;
use App\Exceptions\Payment\PixTransactionNotCreatedException;
use App\Models\Customer;
use App\Repositories\Purchase\PurchaseRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Services\Payment\Contracts\CreditCardResponseInterface;
use App\Services\Payment\Contracts\PaymentServiceInterface;
use App\Services\Payment\Contracts\TransactionResponseInterface;
use App\Services\Payment\DTO\CreditCardDTO;
use App\Services\Payment\DTO\CustomerDTO;
use App\Services\Payment\DTO\TransactionDTO;
use App\Services\Payment\PaymentGateways\Pagarme\Transaction\Billing;
use App\Services\Payment\PaymentGateways\Pagarme\Transaction\Items;
use App\Services\Payment\PaymentService;
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
        $this->paymentService = app(PaymentService::class);
    }

    /**
     * @throws Exception
     */
    public function makeCreditCardTransaction(Customer $customer, Fluent $data): TransactionResponseInterface
    {
        $transaction = $this->getTransaction($customer, $data);

        $transactionResponse = $this->paymentService->creditCard()->createSimpleTransaction($transaction);

        $this->saveTransaction($transactionResponse, $customer, $transaction);

        return $transactionResponse;
    }

    /**
     * @throws PixTransactionNotCreatedException
     */
    public function makePixTransaction(Customer $customer, Fluent $data): TransactionResponseInterface
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
    public function makeBoletoTransaction(Customer $customer, Fluent $data): TransactionResponseInterface
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
    private function getTransaction(Customer $customer, Fluent $data): TransactionDTO
    {
        $document = new Document($customer->document_value);

        $customerDTO = $this->getCustomer($customer, $document);

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

    private function getCustomer(Customer $customer, Document $document): CustomerDTO
    {
        return new CustomerDTO(
            $customer->first_name,
            $customer->last_name,
            $customer->email,
            'br',
            $document,
            '+' .$customer->phone_value,
            $customer->getKey(),
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

    private function saveTransaction(TransactionResponseInterface $transactionResponse, Customer $customer, TransactionDTO $transaction): void
    {
        DB::transaction(function () use ($transactionResponse, $customer, $transaction) {
            $transactionModel = $this->transactionRepository->store($customer, $transactionResponse);
            $this->purchaseRepository->store($transactionModel, $customer, $transaction->items());
        });
    }
}
