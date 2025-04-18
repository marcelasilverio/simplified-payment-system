<?php

namespace App\Payment\Services;

class WalletService extends Service
{
    public function __construct(WalletRepository $repository) {
        parent::__construct(null, $repository);
    }

    public function updateUsersWalletByPayment(PaymentModel $payment): void
    {
        $payerWallet = $this->repository->getWalletByUserId($payment->payer->id);
        $payeeWallet = $this->repository->getWalletByUserId($payment->payee->id);

        $payerWallet->balance -= $payment->value;
        $payeeWallet->balance += $payment->value;

        $this->repository->updateWallet($payerWallet);
        $this->repository->updateWallet($payeeWallet);
    }

    public function getUserBalance(UserModel $user): float
    {
        $wallet = $this->repository->getWalletByUserId($user->id);

        return $wallet->balance;
    }
}