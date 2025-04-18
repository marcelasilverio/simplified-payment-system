<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\PaymentCreatedEvent;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PaymentServiceValidator::class, function ($app) {
            return new PaymentServiceValidator();
        });
    }

    public function boot(): void
    {
        Event::listen(
            PaymentCreatedEvent::class,
        );
    }
}
