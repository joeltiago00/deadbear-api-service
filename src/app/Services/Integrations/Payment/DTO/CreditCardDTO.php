<?php

namespace App\Services\Integrations\Payment\DTO;

class CreditCardDTO
{
    public function __construct(
        public readonly string $holderName,
        public readonly string $number,
        public readonly string $expirationDate,
        public readonly string $cvv
    ) { }

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
