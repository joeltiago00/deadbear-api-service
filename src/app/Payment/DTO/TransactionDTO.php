<?php

namespace App\Payment\DTO;

use App\Enums\Payment\PaymentMethodEnum;
use App\Payment\PaymentGateways\Pagarme\Contracts\PagarmeTransactionInterface;
use App\Payment\PaymentGateways\Pagarme\Transaction\Billing;
use App\Payment\PaymentGateways\Pagarme\Transaction\Items;
use Exception;
use Illuminate\Support\Carbon;

class TransactionDTO implements PagarmeTransactionInterface
{
    private int $amount;
    private ?string $cardId;
    private string $paymentMethod;
    private string $postbackUrl;
    private CustomerDTO $customer;
    private Items $items;
    private ?Billing $billing;

    /**
     * @throws Exception
     */
    public function __construct(
        int         $amount,
        string      $paymentMethod,
        string      $postbackUrl,
        CustomerDTO $customer,
        Items       $items,
        ?Billing    $billing,
        ?string     $cardId,
    )
    {
        if ($paymentMethod === PaymentMethodEnum::CREDITCARD->description() && is_null($billing))
            throw new Exception('Missing billing dara');

        $this->amount = $amount;
        $this->cardId = $cardId;
        $this->paymentMethod = $paymentMethod;
        $this->postbackUrl = $postbackUrl;
        $this->customer = $customer;
        $this->items = $items;
        $this->billing = $billing;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCardId(): ?string
    {
        return $this->cardId;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    public function getPostbackUrl(): string
    {
        return $this->postbackUrl;
    }

    public function customer(): CustomerDTO
    {
        return $this->customer;
    }

    public function billing(): ?Billing
    {
        return $this->billing;
    }

    public function items(): Items
    {
        return $this->items;
    }

    public function getExpirationDate(): Carbon
    {
        return Carbon::now()->addMinutes(30);
    }

    public function getBoletoExpirationDate(): string
    {
        return Carbon::now()->addDays(7)->format('Y-m-d');
    }
}
