<?php

namespace App\Payment\PaymentGateways\Pagarme\Transaction;

use App\Payment\PaymentGateways\Pagarme\Contracts\PagarmeTransactionInterface;
use App\Types\PaymentMethodTypes;

class PagarmeTransaction implements PagarmeTransactionInterface
{
    /**
     * @var bool
     */
    private bool $isDelivery;
    /**
     * @var int
     */
    private int $amount;
    /**
     * @var string
     */
    private string $cardId;
    /**
     * @var string
     */
    private string $paymentMethod;
    /**
     * @var string
     */
    private string $postbackUrl;
    /**
     * @var Customer
     */
    private Customer $customer;
    /**
     * @var Items
     */
    private Items $items;
    /**
     * @var Billing|null
     */
    private Billing|null $billing;
    /**
     * @var Shipping|null
     */
    private Shipping|null $shipping;

    /**
     * @param bool $isDelivery
     * @param int $amount
     * @param string $cardId
     * @param string $paymentMethod
     * @param string $postbackUrl
     * @param Customer $customer
     * @param Items $items
     * @param Billing|null $billing
     * @param Shipping|null $shipping
     * @throws \Exception
     */
    public function __construct(
        bool         $isDelivery,
        int          $amount,
        string       $cardId,
        string       $paymentMethod,
        string       $postbackUrl,
        Customer     $customer,
        Items        $items,
        Billing|null $billing = null,
        Shipping|null $shipping = null
    )
    {
        if ($isDelivery && is_null($shipping))
            throw new \Exception('Missing shipping data');

        if ($paymentMethod === PaymentMethodTypes::CREDIT_CARD && is_null($billing))
            throw new \Exception('Missing billing dara');

        $this->isDelivery = $isDelivery;
        $this->amount = $amount;
        $this->cardId = $cardId;
        $this->paymentMethod = $paymentMethod;
        $this->postbackUrl = $postbackUrl;
        $this->customer = $customer;
        $this->items = $items;
        $this->billing = $billing;
        $this->shipping = $shipping;
    }

    /**
     * @return bool
     */
    public function isDelivery(): bool
    {
        return $this->isDelivery;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCardId(): string
    {
        return $this->cardId;
    }

    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    /**
     * @return string
     */
    public function getPostbackUrl(): string
    {
        return $this->postbackUrl;
    }

    /**
     * @return Customer
     */
    public function customer(): Customer
    {
        return $this->customer;
    }

    /**
     * @return Billing|null
     */
    public function billing(): ?Billing
    {
        return $this->billing;
    }

    /**
     * @return Shipping|null
     */
    public function shipping(): ?Shipping
    {
        return $this->shipping;
    }

    /**
     * @return Items
     */
    public function items(): Items
    {
        return $this->items;
    }
}
