<?php

namespace App\Core\Payment;

use App\Core\Address\Address;
use App\Core\Document\Document;
use App\Exceptions\Transaction\TransactionFail;
use App\Models\Card;
use App\Models\Client;
use App\Models\Item;
use App\Payment\Contracts\CreditCardResponseInterface;
use App\Payment\Contracts\PaymentServiceInterface;
use App\Payment\PaymentGateways\Pagarme\Transaction\Billing;
use App\Payment\PaymentGateways\Pagarme\Transaction\Customer;
use App\Payment\PaymentGateways\Pagarme\Transaction\Items;
use App\Payment\PaymentGateways\Pagarme\Transaction\PagarmeTransaction;
use App\Payment\PaymentGateways\Pagarme\Transaction\Shipping;
use App\Repositories\AddressRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\TransactionRepository;
use App\Types\AddressTypes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;

class Payment
{
    private PaymentServiceInterface $paymentService;
    private CustomerRepository $customerRepository;
    protected TransactionRepository $transactionRepository;
    private AddressRepository $addressRepository;

    public function __construct()
    {
        $this->paymentService = app(\App\Payment\Payment::class);
        $this->customerRepository = new CustomerRepository();
        $this->transactionRepository = new TransactionRepository();
        $this->addressRepository = new AddressRepository();
    }
//card_cl6dl1ikh0sru0t9t70ozmt3x

    /**
     * @param Fluent $data
     * @return CreditCardResponseInterface
     */
    public function createCreditCard(Fluent $data): CreditCardResponseInterface
    {
        $card = new CreditCard($data->holder_name, $data->number, $data->expiration_date, $data->cvv);

        return $this->paymentService->creditCard()->create($card);
    }

    public function createSimpleCreditCardTransaction(
        string $payment_method,
        bool $is_delivery,
        Client $client,
        \App\Models\Customer $customer,
        Card $card,
        ?\App\Models\Address $billing = null,
        ?\App\Models\Address $shipping = null,
        Item ...$items
    ): string
    {
        $document = new Document($customer->document_value);

        $customer = new Customer(
            $customer->id,
            $customer->name,
            $customer->email,
            $customer->country,
            $document,
            $customer->phone_number
        );


        $items = new Items([
            'id' => '1',
            'title' => 'Product Test',
            'unit_price' => 500,
            'quantity' => 2,
            'tangible' => true
        ]);

        $billing_address = new Address(
            $billing->street,
            $billing->number,
            $billing->neighborhood,
            $billing->zipcode,
            $billing->city,
            $billing->state,
            $billing->country
        );

        $billing = new Billing(
            $billing->payer_name,
            $billing_address
        );

            $shipping_address = new Address(
                $shipping->street,
                $shipping->number,
                $shipping->neighborhood,
                $shipping->zipcode,
                $shipping->city,
                $shipping->state,
                $shipping->country
            );

        $shipping = new Shipping(
            $shipping->receiver_name,
            $shipping->fee,
            $shipping->delivery_date,
            $shipping_address
        );

        $transaction = new PagarmeTransaction(
            $is_delivery,
            1000,
            $card->provider_hash,
            $payment_method,
            '',
            $customer,
            $items,
            $billing,
            $shipping
        );

        $response = $this->paymentService->creditCard()->createSimpleTransaction($transaction);

        try {
            DB::beginTransaction();

            $customer_model = $this->customerRepository->store($client, $customer);

            $transaction_model = $this->transactionRepository->store($customer_model, $response);

            $billing_address_model = $this->addressRepository->store($transaction_model, $billing_address, AddressTypes::BILLING);

            $shipping_address_model = $this->addressRepository->store($transaction_model, $shipping_address, AddressTypes::SHIPPING);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new TransactionFail($exception);
        }

        dd();
    }

    private function simpleCreditCardWithDelivery()
    {

    }
}
