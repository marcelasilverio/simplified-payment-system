<?php

namespace App\Services\Payment;

use App\Models\UserModel;
use App\Models\PaymentModel;
use App\Repositories\Payment\WalletRepository;
use App\Services\Service;

class WalletService extends Service
{
    public function __construct(WalletRepository $repository)
    {
        parent::__construct(repository: $repository, validator: null);
    }

    public function updateUsersWalletByPayment(PaymentModel $payment): void
    {
        $this->repository->updateUsersWalletByPayment(payment: $payment);
    }

    public function getUserBalance(UserModel $user): float
    {
        $wallet = $this->repository->getWalletByUserId(user: $user);

        return $wallet->balance ?? $user->initial_balance;
    }
}