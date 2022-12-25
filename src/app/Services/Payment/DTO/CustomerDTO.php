<?php

namespace App\Services\Payment\DTO;

use App\Core\Document\Document;

class CustomerDTO
{
    public function __construct(
        public readonly ?string $firstName,
        public readonly ?string $lastName,
        public readonly ?string $email,
        public readonly ?string $country,
        public readonly ?Document $document,
        public readonly ?string $phone,
        public readonly ?string $externalId = '',
    ) { }

    public function toArray(): array
    {
        return [
            'external_id' => $this->externalId,
            'name' => sprintf('%s %s', $this->firstName, $this->lastName),
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

