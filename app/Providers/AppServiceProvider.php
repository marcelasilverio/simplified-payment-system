<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PaymentServiceValidator::class, function ($app) {
            return new PaymentServiceValidator();
        });
    }
}
