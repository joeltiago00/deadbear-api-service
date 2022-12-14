<?php

namespace App\Core\Payment;

use App\Core\Payment\Contracts\CreditCardInterface;
use JetBrains\PhpStorm\ArrayShape;

class CreditCard implements CreditCardInterface
{
    /**
     * @param string $holderName
     * @param string $number
     * @param string $expirationDate
     * @param string $cvv
     */
    public function __construct(
        private readonly string $holderName,
        private readonly string $number,
        private readonly string $expirationDate,
        private readonly string $cvv
    ) { }

    /**
     * @return string
     */
    public function getHolderName(): string
    {
        return $this->holderName;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getExpirationDate(): string
    {
        return $this->expirationDate;
    }

    /**
     * @return string
     */
    public function getCvv(): string
    {
        return $this->cvv;
    }

    /**
     * @return array
     */
    #[ArrayShape(['holder_name' => "string", 'number' => "string", 'expiration_date' => "string", 'cvv' => "string"])]
    public function toArray(): array
    {
        return [
            'holder_name' => $this->holderName,
            'number' => $this->number,
            'expiration_date' => $this->expirationDate,
            'cvv' => $this->cvv
        ];
    }
}
