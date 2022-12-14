<?php

namespace App\Core\Address\Contracts;

interface AddressInterface
{
    public function getStreet(): string;

    public function getNumber(): string;

    public function getNeighborhood(): string;

    public function getZipcode(): string;

    public function getCity(): string;

    public function getState(): string;

    public function getCountry(): string;

    public function toArray(): array;
}
