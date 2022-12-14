<?php

namespace App\Payment\PaymentGateways\Pagarme;

use App\Exceptions\Payment\PixTransactionNotCreatedException;
use App\Payment\Contracts\PixInterface;
use App\Payment\Contracts\TransactionResponseInterface;
use App\Payment\DTO\TransactionDTO;
use App\Payment\PaymentGateways\Pagarme\Contracts\PagarmeOperationInterface;
use App\Payment\PaymentGateways\Pagarme\Transaction\PagarmeTransactionResponse;
use Illuminate\Support\Fluent;
use PagarMe\Client;

class Pix implements PixInterface, PagarmeOperationInterface
{
    public function __construct(
        private readonly Client $client
    ){ }

    /**
     * @throws PixTransactionNotCreatedException
     */
    public function makeTransaction(TransactionDTO $transaction): TransactionResponseInterface
    {
        $payload = [
            'customer' => [
                'external_id' => $transaction->customer()->getExternalId(),
                'name' => $transaction->customer()->getName(),
                'email' => $transaction->customer()->getEmail(),
                'type' => 'individual',
                'country' => 'br',
                'documents' => [
                    [
                        'type' => $transaction->customer()->document()->getType(),
                        'number' => $transaction->customer()->document()->getValue()
                    ]
                ],
                'phone_numbers' => [$transaction->customer()->getPhone()]
            ],
            'items' => $transaction->items()->getItems(),
            'postback_url' => $transaction->getPostbackUrl(),
            'payment_method' => $transaction->getPaymentMethod(),
            'amount' => $transaction->getAmount(),
            'pix_expiration_date' => $transaction->getExpirationDate(),
        ];

        try {
            $response = $this->client->transactions()->create($payload);
        } catch (\Exception $exception) {
            throw new PixTransactionNotCreatedException($exception);
        }

        return new PagarmeTransactionResponse(new Fluent($response));
    }
}
