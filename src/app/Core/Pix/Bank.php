<?php

namespace App\Core\Payment\Pix;

use App\Core\Payment\Contracts\BankInterface;
use JetBrains\PhpStorm\ArrayShape;

class Bank implements BankInterface
{
    /**
     * @param string $name
     * @param string $ispb
     * @param string $agency
     * @param string $accountNumber
     */
    public function __construct(
        private readonly string $name,
        private readonly string $ispb,
        private readonly string $agency,
        private readonly string $accountNumber
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
    public function getISPB(): string
    {
        return $this->ispb;
    }

    /**
     * @return string
     */
    public function getAgency(): string
    {
        return $this->agency;
    }

    /**
     * @return string
     */
    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    /**
     * @return array
     */
    #[ArrayShape(['bank_name' => "string", 'bank_ispb' => "string", 'bank_agency' => "string",
        'bank_account_number' => "string"])]
    public function toArray(): array
    {
        return [
            'bank_name' => $this->name,
            'bank_ispb' => $this->ispb,
            'bank_agency' => $this->agency,
            'bank_account_number' => $this->accountNumber
        ];
    }
}
