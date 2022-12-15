<?php

namespace App\Payment\DTO;

use App\Core\Document\Document;

class CustomerDTO
{
    public function __construct(
        private readonly string $externalId,
        private readonly string $name,
        private readonly string $email,
        private readonly string $country,
        private readonly Document $document,
        private readonly string $phone
    ) { }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function document(): Document
    {
        return $this->document;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function toArray(): array
    {
        return [
            'external_id' => $this->externalId,
            'name' => $this->name,
            'email' => $this->email,
            'type' => 'individual',
            'country' => $this->country,
            'documents' => [
                $this->document->toArray()
            ],
            'phone_numbers' => [$this->phone]
        ];
    }
}

