<?php

namespace App\Providers;

use App\Services\Payment\PaymentService;
use App\Services\Payment\PaymentServiceManager;
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
        $this->app->bind(PaymentService::class, fn() => (new PaymentServiceManager())->resolve());
    }
}
