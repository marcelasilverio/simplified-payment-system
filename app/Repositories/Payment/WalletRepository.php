<?php

namespace App\Repositories\Payment;

use Illuminate\Support\Facades\DB;

use App\Repositories\Repository;
use App\Models\UserModel;
use App\Models\WalletModel;
use App\Models\PaymentModel;

class WalletRepository extends Repository
{
    public function __construct(WalletModel $model)
    {
        parent::__construct(model: $model);
    }

    public function updateUsersWalletByPayment(PaymentModel $payment): void
    {
        DB::transaction(callback: function () use ($payment): void {
            $this->updateUserWallet(user: $payment->payer);
            $this->updateUserWallet(user: $payment->payee);
        });
    }

    public function getWalletByUserId(UserModel $user): ?WalletModel
    {
        return $this->model::where(column: 'user_id', operator: $user->id)->first();
    }

    private function updateUserWallet(UserModel $user): void
    {
        $totalBalance = (PaymentModel::where(column: 'payee_id', operator: $user->id)
            ->sum(column: 'value') - PaymentModel::where(column: 'payer_id', operator: $user->id)
                ->sum(column: 'value')) + $user->initial_balance;

        $this->model::updateOrCreate(
            attributes: ['user_id' => $user->id],
            values: ['balance' => $totalBalance]
        );
    }
}