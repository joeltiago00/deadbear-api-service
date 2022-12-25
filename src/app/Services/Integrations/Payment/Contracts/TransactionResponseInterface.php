<?php

namespace App\Services\Integrations\Payment\Contracts;

interface TransactionResponseInterface
{
    public function getTransactionId(): int;

    public function getStatus(): string;

    public function getRefuseReason(): ?string;

    public function getStatusReason(): ?string;

    public function getAcquirerResponseCode(): ?string;

    public function getAcquirerResponseMessage(): ?string;

    public function getAuthorizationCode(): ?string;

    public function getAmount(): int;

    public function getAuthorizedAmount(): int;

    public function getPaidAmount(): int;

    public function getRefundedAmount(): int;

    public function getPaymentMethod(): string;

    public function getPostbackUrl(): ?string;

    public function getPixQRCode(): ?string;

    public function getPixExpirationDate(): ?string;

    public function getRiskLevel(): ?string;

    public function getBoletoUrl(): ?string;

    public function getBoletoBarcode(): ?string;

    public function getBoletoExpirationDate(): ?string;

    public function toArray(): array;
}
