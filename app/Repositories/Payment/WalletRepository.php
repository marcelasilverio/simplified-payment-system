<?php

namespace App\Repositories\Payment;

use App\Repositories\Repository;
use App\Models\WalletModel;
use App\Models\PaymentModel;

class WalletRepository extends Repository 
{
    public function __construct(WalletModel $model) {
        parent::__construct($model);
    }

    public function updateUsersWalletByPayment(PaymentModel $payment): void
    {
        DB::transaction(function () use ($payment) {
            $this->updateUserWallet($payment->payer);
            $this->updateUserWallet($payment->payee);
        });
    }

    public function getWalletBalanceByUserId(UserModel $user): ?WalletModel
    {
        return $this->model::where('user_id', $user->id)->first();
    }

    private function updateUserWallet(UserModel $user): void
    {
        $totalBalance = PaymentModel::where('payee_id', $user->id)
            ->sum('value') - PaymentModel::where('payer_id', $user->id)
            ->sum('value');

        $this->model::updateOrCreate(
            ['user_id' => $user->id],
            ['balance' => $totalBalance]
        );
    }
}