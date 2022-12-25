<?php

namespace App\Services\Payment\PaymentGateways\Pagarme;

use App\Exceptions\Payment\CreditCardNotCreatedException;
use App\Exceptions\Payment\CreditCardNotGetedException;
use App\Exceptions\Payment\CreditCardTransactionNotCreatedException;
use App\Services\Payment\Contracts\CreditCardInterface;
use App\Services\Payment\Contracts\CreditCardResponseInterface;
use App\Services\Payment\Contracts\TransactionResponseInterface;
use App\Services\Payment\DTO\CreditCardDTO;
use App\Services\Payment\PaymentGateways\Pagarme\Contracts\PagarmeOperationInterface;
use App\Services\Payment\PaymentGateways\Pagarme\Contracts\PagarmeTransactionInterface;
use App\Services\Payment\PaymentGateways\Pagarme\Responses\CreditCardResponse;
use App\Services\Payment\PaymentGateways\Pagarme\Responses\PagarmeTransactionResponse;
use Illuminate\Support\Fluent;
use PagarMe\Client;

class CreditCard implements CreditCardInterface, PagarmeOperationInterface
{
    public function __construct(
        private readonly Client $client,
    ) { }

    /**
     * @throws CreditCardNotGetedException
     */
    public function get(array $payload): CreditCardResponseInterface
    {
        try {
            $response = $this->client->cards()->get($payload);
        } catch (\Exception $exception) {
            throw new CreditCardNotGetedException($exception);
        }

        return new CreditCardResponse(new Fluent($response));
    }

    /**
     * @throws CreditCardTransactionNotCreatedException
     */
    public function createSimpleTransaction(PagarmeTransactionInterface $transaction): TransactionResponseInterface
    {
        $payload = [
            'amount' => $transaction->getAmount(),
            'card_id' => $transaction->getCardId(),
            'payment_method' => $transaction->getPaymentMethod(),
            'postback_url' => $transaction->getPostbackUrl(),
            'customer' => $transaction->customer()->toArray(),
            'billing' => $transaction->billing()->toArray(),
            'items' => $transaction->items()->getItems()
        ];

        try {
            $response = $this->client->transactions()->create($payload);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            throw new CreditCardTransactionNotCreatedException($exception);
        }

        return new PagarmeTransactionResponse(new Fluent($response));
    }

    public function createRecurrentTransaction(PagarmeTransactionInterface $transaction): TransactionResponseInterface
    {
        // TODO: Implement createRecurrentTransaction() method.
    }

    /**
     * @throws CreditCardNotCreatedException
     */
    public function create(CreditCardDTO $card): CreditCardResponseInterface
    {
        try {
            $card = $this->client->cards()->create($card->toArray());
        } catch (\Exception $exception) {
            throw new CreditCardNotCreatedException($exception);
        }

        return new CreditCardResponse(new Fluent($card));
    }
}
