<?php

namespace App\Providers;

use App\Payment\Payment;
use App\Payment\PaymentServiceManager;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->bind(Payment::class, fn() => (new PaymentServiceManager())->resolve());
    }
}
