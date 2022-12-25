<?php

namespace App\Services\Integrations\Payment\PaymentGateways\Pagarme\Responses;

use App\Services\Integrations\Payment\Contracts\TransactionResponseInterface;
use Illuminate\Support\Fluent;

class PagarmeTransactionResponse implements TransactionResponseInterface
{
    public function __construct(
        private readonly Fluent $response,
    ) { }

    /**
     * @return int
     */
    public function getTransactionId(): int
    {
        return $this->response->id;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->response->status;
    }

    /**
     * @return string|null
     */
    public function getRefuseReason(): ?string
    {
        return $this->response->refuse_reason;
    }

    /**
     * @return string|null
     */
    public function getStatusReason(): ?string
    {
        return $this->response->status_reason;
    }

    /**
     * @return string|null
     */
    public function getAcquirerResponseCode(): ?string
    {
        return $this->response->acquirer_response_code;
    }

    /**
     * @return string|null
     */
    public function getAcquirerResponseMessage(): ?string
    {
        return $this->response->acquirer_response_message;
    }

    /**
     * @return string|null
     */
    public function getAuthorizationCode(): ?string
    {
        return $this->response->authorization_code;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->response->amount;
    }

    /**
     * @return int
     */
    public function getAuthorizedAmount(): int
    {
        return $this->response->authorized_amount;
    }

    /**
     * @return int
     */
    public function getPaidAmount(): int
    {
        return $this->response->paid_amount;
    }

    /**
     * @return int
     */
    public function getRefundedAmount(): int
    {
        return $this->response->refunded_amount;
    }

    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->response->payment_method;
    }

    /**
     * @return string|null
     */
    public function getPostbackUrl(): ?string
    {
        return $this->response->postback_url;
    }

    /**
     * @return string|null
     */
    public function getPixQRCode(): ?string
    {
        return $this->response->pix_qr_code;
    }

    /**
     * @return string|null
     */
    public function getPixExpirationDate(): ?string
    {
        return $this->response->pix_expiration_date;
    }

    /**
     * @return string|null
     */
    public function getRiskLevel(): ?string
    {
        return $this->response->risk_level;
    }

    /**
     * @return string|null
     */
    public function getBoletoUrl(): ?string
    {
        return $this->response->boleto_url;
    }

    /**
     * @return string|null
     */
    public function getBoletoBarcode(): ?string
    {
        return $this->response->boleto_barcode;
    }

    /**
     * @return string|null
     */
    public function getBoletoExpirationDate(): ?string
    {
        return $this->response->boleto_expiration_date;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'transaction_provider_id' => $this->response->id,
            'payment_provider' => config('app.payment.default_gateway'),
            'status' => $this->response->status,
            'refuse_reason' => $this->response->refuse_reason,
            'status_reason' => $this->response->status_reason,
            'acquirer_response_code' => $this->response->acquirer_response_code,
            'acquirer_response_message' => $this->response->acquirer_response_message,
            'authorization_code' => $this->response->authorization_code,
            'amount' => $this->response->amount,
            'authorized_amount' => $this->response->authorized_amount,
            'paid_amount' => $this->response->paid_amount,
            'refunded_amount' => $this->response->refunded_amount,
            'payment_method' => $this->response->payment_method,
            'postback_url' => $this->response->postback_url,
            'pix_qr_code' => $this->response->pix_qr_code,
            'pix_expiration_date' => $this->response->pix_expiration_date,
            'risk_level' => $this->response->risk_level,
            'boleto_url' => $this->response->boleto_url,
            'boleto_barcode' => $this->response->boleto_barcode,
            'boleto_expiration_date' => $this->response->boleto_expiration_date,
        ];
    }
}
