<?php

namespace App\Events;

use App\Models\Customer;
use App\Models\Purchase;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AutoSendBuy
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        public readonly Customer $customer,
        public readonly Purchase $purchase,
        public readonly string $status)
    {
        //
    }
}
