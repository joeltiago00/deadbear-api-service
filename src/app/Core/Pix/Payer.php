<?php

namespace App\Core\Payment\Pix;

use App\Core\Payment\Contracts\PixPayerInterface;
use JetBrains\PhpStorm\ArrayShape;

class Payer implements PixPayerInterface
{
    /**
     * @param string $name
     * @param string $documentType
     * @param string $documentValue
     */
    public function __construct(
        private readonly string $name,
        private readonly string $documentType,
        private readonly string $documentValue
    ) { }

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
    public function getDocumentType(): string
    {
        return $this->documentType;
    }

    /**
     * @return string
     */
    public function getDocumentValue(): string
    {
        return $this->documentValue;
    }

    /**
     * @return array
     */
    #[ArrayShape(['name' => "string", 'document_type' => "string", 'document_value' => "string"])]
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'document_type' => $this->documentType,
            'document_value' => $this->documentValue
        ];
    }
}
