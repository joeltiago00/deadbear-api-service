<?php

namespace App\Core\Document;

use App\Core\Document\Contracts\DocumentInterface;
use JetBrains\PhpStorm\ArrayShape;

class Document implements DocumentInterface
{
    /**
     * @var string
     */
    private string $value;
    /**
     * @var string
     */
    private string $type;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->type = 'cpf'; //TODO:: Get type by country
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return array
     */
    #[ArrayShape(['type' => "string", 'number' => "string"])]
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'number' => $this->value
        ];
    }

    /**
     * @param string $value
     * @return void
     */
    private function setValue(string $value): void
    {
        //TODO:: Implement validation by country
        $this->value = $value;
    }
}
