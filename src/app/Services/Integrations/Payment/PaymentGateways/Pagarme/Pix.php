<?php

namespace App\Services\Integrations\Payment\PaymentGateways\Pagarme;

use App\Exceptions\Payment\PixTransactionNotCreatedException;
use App\Services\Integrations\Payment\Contracts\PixInterface;
use App\Services\Integrations\Payment\Contracts\TransactionResponseInterface;
use App\Services\Integrations\Payment\DTO\TransactionDTO;
use App\Services\Integrations\Payment\PaymentGateways\Pagarme\Contracts\PagarmeOperationInterface;
use App\Services\Integrations\Payment\PaymentGateways\Pagarme\Responses\PagarmeTransactionResponse;
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
    public function createTransaction(TransactionDTO $transaction): TransactionResponseInterface
    {
        $payload = [
            'customer' => [
                'external_id' => $transaction->customer()->externalId,
                'name' => sprintf('%s %s', $transaction->customer()->firstName, $transaction->customer()->lastName),
                'email' => $transaction->customer()->email,
                'type' => 'individual',
                'country' => 'br',
                'documents' => [
                    [
                        'type' => $transaction->customer()->document->getType(),
                        'number' => $transaction->customer()->document->getValue()
                    ]
                ],
                'phone_numbers' => [$transaction->customer()->phone]
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
