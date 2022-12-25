<?php

namespace App\Services\Payment\PaymentGateways\Pagarme;

use App\Exceptions\Payment\BoletoTransactionNotCreatedException;
use App\Services\Payment\DTO\TransactionDTO;
use App\Services\Payment\PaymentGateways\Pagarme\Contracts\PagarmeOperationInterface;
use App\Services\Payment\PaymentGateways\Pagarme\Responses\PagarmeTransactionResponse;
use Illuminate\Support\Fluent;
use PagarMe\Client;

class Boleto implements PagarmeOperationInterface
{

    public function __construct(private readonly Client $client)
    {
    }

    /**
     * @throws BoletoTransactionNotCreatedException
     */
    public function createTransaction(TransactionDTO $transaction): PagarmeTransactionResponse
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
            'boleto_expiration_date' => $transaction->getBoletoExpirationDate(),
        ];

        try {
            $response = $this->client->transactions()->create($payload);
        } catch (\Exception $exception) {
            throw new BoletoTransactionNotCreatedException($exception);
        }

        return new PagarmeTransactionResponse(new Fluent($response));
    }
}
