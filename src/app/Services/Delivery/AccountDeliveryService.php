<?php

namespace App\Services\Delivery;

use App\Core\ProductSend\ItemDTO;
use App\Enums\Payment\PaymentStatusEnum;
use App\Events\AutoSendBuy;
use App\Mail\EmptyStockMail;
use App\Mail\PurchaseSendMail;
use App\Models\Purchase;
use App\Repositories\AccountStock\AccountStockRepository;
use App\Repositories\Purchase\PurchaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AccountDeliveryService
{
    public function __construct(
        private readonly AccountStockRepository $accountStockRepository,
        private readonly PurchaseRepository     $purchaseRepository
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function delivery(AutoSendBuy $event): void
    {
        if ($event->status === PaymentStatusEnum::PAID->description() && !$event->purchase->is_delivered) {
            $items = $event->purchase->purchaseItems()->get();

            $accounts = $this->getAccounts($items);

            //TODO:: handle this
            if ($accounts->count() === 0) {
                //TODO:: adicionar tipo de conta no email
                Mail::to('contato@deadbear.com')->send(new EmptyStockMail());
                return;
            }

            $dtos = $this->getItemsDTO($accounts);

            try {
                DB::beginTransaction();

                $this->setAccountsDelivered($event->purchase, $accounts, $accounts);

                Mail::to($event->customer->email)->send(new PurchaseSendMail($event->customer, $dtos));

                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                //TODO:: implementar log e excessão customizada!
                throw new \Exception('Email not send.');
            }
        }
    }

    private function setAccountsDelivered(Purchase $purchase, SupportCollection $items, SupportCollection $accounts): void
    {
        DB::transaction(function () use ($purchase, $items, $accounts) {
            $this->purchaseRepository->setDelivered($purchase);

            $accounts->map(function ($account) use ($purchase) {
                $account->each(function ($acc) use ($purchase) {
                    $this->accountStockRepository->setAccountDelivered($acc, $purchase->id);
                });
            });
        });
    }

    private function getItemsDTO(SupportCollection $accounts): array
    {
        $items = collect();

        $accounts->map(function ($accounts) use ($items) {
            return $accounts->map(function ($account) use ($items) {
                $items->push(new ItemDTO(
                    $account->login,
                    $account->password,
                    $account->email
                ));
            });
        });

        return $items->toArray();
    }

    private function getAccounts(Collection $items): SupportCollection|Collection
    {
        $accounts = collect();

        $items->each(function ($item) use ($accounts) {
            return $accounts->push($this->accountStockRepository->getAccounts($item->item_id, $item->quantity));
        });

        return $accounts;
    }
}
