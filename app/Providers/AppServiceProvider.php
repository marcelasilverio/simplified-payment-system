<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Services\External\ExternalAuthorizationApi\ExternalAuthorizationApiService;
use App\Services\External\ExternalNotificationApi\ExternalNotificationApiService;
use App\Interfaces\PaymentAuthorizationServiceInterface;
use App\Interfaces\NotificationServiceInterface;
use App\Services\Payment\PaymentService;
use App\Validators\Payment\PaymentServiceValidator;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\Payment\WalletRepository;
use App\Services\Payment\WalletService;
use App\Models\PaymentModel;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PaymentServiceValidator::class, function ($app) {
            return new PaymentServiceValidator(
                $app->make(PaymentAuthorizationServiceInterface::class),
                $app->make(WalletService::class)
            );
        });

        $this->app->singleton(PaymentRepository::class, function ($app) {
            return new PaymentRepository($app->make(PaymentModel::class));
            });

        $this->app->singleton(PaymentService::class, function ($app) {
            return new PaymentService(
                $app->make(PaymentServiceValidator::class),
                $app->make(PaymentRepository::class),
                $app->make(NotificationServiceInterface::class)
            );
        });

        $this->app->singleton(WalletRepository::class, function ($app) {
            return $app->make(WalletRepository::class);
        });
            
        $this->app->singleton(WalletService::class, function ($app) {
            return new WalletService($app->make(WalletRepository::class));
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
            [UpdateWalletsListener::class, 'handle']
        );
    }
}
