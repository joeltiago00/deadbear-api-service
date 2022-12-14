<?php

namespace App\Payment\PaymentGateways\Pagarme\Transaction;

use App\Core\Document\Contracts\DocumentInterface;
use JetBrains\PhpStorm\ArrayShape;

class Customer
{
    /**
     * @param string $externalId
     * @param string $name
     * @param string $email
     * @param string $country
     * @param DocumentInterface $document
     * @param string $phone
     */
    public function __construct(
        private readonly string $externalId,
        private readonly string $name,
        private readonly string $email,
        private readonly string $country,
        private readonly DocumentInterface $document,
        private readonly string $phone
    ) { }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return DocumentInterface
     */
    public function document(): DocumentInterface
    {
        return $this->document;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return array
     */
    #[ArrayShape(['external_id' => "int", 'name' => "string", 'email' => "string", 'type' => "string",
        'country' => "string", 'documents' => "array", 'phone_numbers' => "string[]"])]
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

