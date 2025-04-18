<?php

namespace App\Payment\Services;

use App\Models\UserModel;
use App\Models\PaymentModel;
use App\Repositories\Payment\WalletRepository;
use App\Services\Service;

class WalletService extends Service
{
    public function __construct(WalletRepository $repository) {
        parent::__construct(null, $repository);
    }

    public function updateUsersWalletByPayment(PaymentModel $payment): void
    {
        $this->repository->updateWalletByPayment($payment);
    }

    public function getUserBalance(UserModel $user): double
    {
        $wallet = $this->repository->getWalletByUserId($user);

        return $wallet->balance ?? $user->initial_balance;
    }
}