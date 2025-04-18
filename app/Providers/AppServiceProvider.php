<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

use ExternalAuthorizationApiService;
use ExternalNotificationApiService;
use App\Interfaces\PaymentAuthorizationServiceInterface;
use App\Interfaces\NotificationServiceInterface;
use App\Services\Payment\PaymentService;
use App\Validators\Payment\PaymentServiceValidator;
use App\Repositories\Payment\PaymentRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PaymentServiceValidator::class, function ($app) {
            return new PaymentServiceValidator($app->make(PaymentAuthorizationServiceInterface::class));
        });

        $this->app->singleton(PaymentRepository::class, function ($app) {
            return new PaymentRepository();
        });

        $this->app->singleton(PaymentService::class, function ($app) {
            return new PaymentService(
                $app->make(PaymentServiceValidator::class),
                $app->make(PaymentRepository::class),
                $app->make(NotificationServiceInterface::class)
            );
        });

        $this->app->bind(NotificationServiceInterface::class, function ($app) {
            return $app->make(ExternalNotificationApiService::class);
        });

        $this->app->bind(PaymentAuthorizationServiceInterface::class, function ($app) {
            return $app->make(ExternalAuthorizationApiService::class);
        });
    }

    public function boot(): void
    {
        Event::listen(
            PaymentCreatedEvent::class,
        );
    }
}
