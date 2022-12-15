<?php

namespace App\Listeners;

use App\Events\AutoSendBuy;
use App\Services\Delivery\AccountDeliveryService;

class AutoSendBuyEmail
{
    public function __construct(private readonly AccountDeliveryService $accountDeliveryService)
    {
    }

    /**
     * @throws \Exception
     */
    public function handle(AutoSendBuy $event): void
    {
        $this->accountDeliveryService->delivery($event);
    }
}
