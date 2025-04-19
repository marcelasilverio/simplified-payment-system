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
use App\Events\PaymentCreatedEvent;
use App\Listeners\UpdateWalletsListener;
use App\Models\PaymentModel;
use App\Models\WalletModel;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(abstract: NotificationServiceInterface::class, concrete: function ($app): mixed {
            return $app->make(ExternalNotificationApiService::class);
        });

        $this->app->bind(abstract: PaymentAuthorizationServiceInterface::class, concrete: function ($app): mixed {
            return $app->make(ExternalAuthorizationApiService::class);
        });

        $this->app->singleton(abstract: PaymentServiceValidator::class, concrete: function ($app): PaymentServiceValidator {
            return new PaymentServiceValidator(
                paymentAuthorizationService: $app->make(PaymentAuthorizationServiceInterface::class),
                walletService: $app->make(WalletService::class)
            );
        });

        $this->app->singleton(abstract: PaymentRepository::class, concrete: function ($app): PaymentRepository {
            return new PaymentRepository(model: $app->make(PaymentModel::class));
        });

        $this->app->singleton(abstract: PaymentService::class, concrete: function ($app): PaymentService {
            return new PaymentService(
                validator: $app->make(PaymentServiceValidator::class),
                repository: $app->make(PaymentRepository::class),
                notificationService: $app->make(NotificationServiceInterface::class)
            );
        });

        $this->app->singleton(abstract: WalletRepository::class, concrete: function ($app): WalletRepository {
            return new WalletRepository(model: $app->make(WalletModel::class));
        });

        $this->app->singleton(abstract: WalletService::class, concrete: function ($app): WalletService {
            return new WalletService(repository: $app->make(WalletRepository::class));
        });
    }

    public function boot(): void
    {
        Event::listen(
            events: PaymentCreatedEvent::class,
            listener: [UpdateWalletsListener::class, 'handle']
        );
    }
}
