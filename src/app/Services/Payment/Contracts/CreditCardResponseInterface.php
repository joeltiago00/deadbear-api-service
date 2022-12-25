<?php

namespace App\Services\Payment\Contracts;

interface CreditCardResponseInterface
{
    public function getCardId(): string;

    public function getBrand(): string;

    public function getHolderName(): string;

    public function getExpirationDate(): string;

    public function getFirstDigits(): string;

    public function getLastDigits(): string;

    public function getCountry(): string;
}
