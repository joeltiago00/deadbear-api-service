<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class InterfaceProvider extends ServiceProvider
{
    public function boot(): void
    {
        foreach (config('interfaces') as $interface => $concrete) {
            $this->app->bind($interface, $concrete);
        }
    }
}
