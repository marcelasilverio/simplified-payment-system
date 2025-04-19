<?php

namespace App\Listeners;

use App\Events\PaymentCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Services\Payment\WalletService;

class UpdateWalletsListener
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function handle(PaymentCreatedEvent $event): void
    {
        $this->walletService->updateUsersWalletByPayment($event->payment);
    }
}
