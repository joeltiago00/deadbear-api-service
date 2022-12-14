<?php

namespace App\Payment\PaymentGateways\Pagarme;

use App\Core\Payment\CreditCardDTO;
use App\Exceptions\Payment\CreditCardNotCreatedException;
use App\Exceptions\Payment\CreditCardNotGetedException;
use App\Exceptions\Payment\CreditCardTransactionNotCreatedException;
use App\Payment\Contracts\CreditCardInterface;
use App\Payment\Contracts\CreditCardResponseInterface;
use App\Payment\Contracts\TransactionResponseInterface;
use App\Payment\PaymentGateways\Pagarme\Contracts\PagarmeOperationInterface;
use App\Payment\PaymentGateways\Pagarme\Contracts\PagarmeTransactionInterface;
use App\Payment\PaymentGateways\Pagarme\Responses\CreditCardResponse;
use App\Payment\PaymentGateways\Pagarme\Transaction\PagarmeTransactionResponse;
use Illuminate\Support\Fluent;
use PagarMe\Client;

class CreditCard implements CreditCardInterface, PagarmeOperationInterface
{
    public function __construct(
        private readonly Client $client,
    ) { }

    /**
     * @param array $payload
     * @return CreditCardResponseInterface
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
     * @param PagarmeTransactionInterface $transaction
     * @return TransactionResponseInterface
     * @throws CreditCardTransactionNotCreatedException
     */
    public function createSimpleTransaction(PagarmeTransactionInterface $transaction): TransactionResponseInterface
    {
        $transaction_data = [
            'amount' => $transaction->getAmount(),
            'card_id' => $transaction->getCardId(),
            'payment_method' => $transaction->getPaymentMethod(),
//            'postback_url' => $transaction->getPostbackUrl(),
            'customer' => $transaction->customer()->toArray(),
            'billing' => $transaction->billing()->toArray(),
            'items' => $transaction->items()->toArray()
        ];

        if ($transaction->isDelivery())
            $transaction_data = array_merge($transaction_data, ['shipping' => $transaction->shipping()->toArray()]);

        try {
            $response = $this->client->transactions()->create($transaction_data);
        } catch (\Exception $exception) {
            throw new CreditCardTransactionNotCreatedException($exception);
        }

        return new PagarmeTransactionResponse(new Fluent($response));
    }

    public function createRecurrentTransaction(PagarmeTransactionInterface $transaction): TransactionResponseInterface
    {
        // TODO: Implement createRecurrentTransaction() method.
    }

    /**
     * @param CreditCardDTO $card
     * @return CreditCardResponseInterface
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
