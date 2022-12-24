<?php

namespace App\Services\Payment;

use App\Core\Payment\Pix\Bank;
use App\Core\Payment\Pix\Payer;
use App\Enums\Payment\PaymentMethodEnum;
use App\Events\AutoSendBuy;
use App\Models\Transaction;
use App\Repositories\Custumer\CustomerRepository;
use App\Repositories\Payer\PayerRepository;
use App\Repositories\Purchase\PurchaseRepository;
use App\Repositories\Transaction\TransactionRepository;
use Illuminate\Support\Fluent;

class PostbackService
{
    public function __construct(
        private readonly TransactionRepository $transactionRepository,
        private readonly PayerRepository       $payerRepository,
        private readonly CustomerRepository    $customerRepository,
        private readonly PurchaseRepository    $purchaseRepository
    )
    {
    }

    public function updateTransaction(Fluent $data): void
    {
        $transaction = $this->transactionRepository->getByTransactionProviderId($data->id);

        $status = $data->current_status;

        if ($status !== $transaction->status)
            $this->transactionRepository->updateTransactionStatus($transaction, $status);

        if ($data->transaction['payment_method'] === PaymentMethodEnum::PIX->description())
            $this->addPixPayerInformation($transaction, $data);

        $customer = $this->customerRepository->getById($transaction->customer_id);

        $purchase = $this->purchaseRepository->getByTransactionId($transaction->getKey());

        event(new AutoSendBuy($customer, $purchase, $status));
    }

    private function addPixPayerInformation(Transaction $transaction, Fluent $data): void
    {
        $this->payerRepository->createByTransaction(
            $transaction,
            new Payer(
                $data->transaction['pix_data']['payer']['name'],
                $data->transaction['pix_data']['payer']['document_type'],
                $data->transaction['pix_data']['payer']['document']
            ),
            new Bank(
                $data->transaction['pix_data']['payer']['bank_account']['bank_name'],
                $data->transaction['pix_data']['payer']['bank_account']['ispb'],
                $data->transaction['pix_data']['payer']['bank_account']['branch_code'],
                $data->transaction['pix_data']['payer']['bank_account']['account_number']
            )
        );
    }
}
