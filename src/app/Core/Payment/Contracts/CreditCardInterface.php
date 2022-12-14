<?php

namespace App\Core\Payment\Contracts;

interface CreditCardInterface
{
    public function __construct(string $holderName, string $number, string $expirationDate, string $cvv);

    public function getHolderName(): string;

    public function getNumber(): string;

    public function getExpirationDate(): string;

    public function getCvv(): string;

    public function toArray(): array;
}
