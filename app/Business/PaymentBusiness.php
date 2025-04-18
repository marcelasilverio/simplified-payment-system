<?php

namespace App\Business;

use App\Models\UserModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class PaymentBusiness
{
    public function transfer(int $payerId, int $payeeId, float $value) {
        
        $this->isTransferTransactionAllowed($payer, $payee, $value);

        DB::transaction(function () use ($payer, $payee, $value) {
            $payer->balance -= $value;
            $payer->save();

            $payee->balance += $value;
            $payee->save();
        });

        $response = Http::post('https://external-service.com/api/notify', [
            'sender_id' => $payer->id,
            'receiver_id' => $payee->id,
            'value' => $value,
        ]);

        $response->json();
    }

    private function isTransferTransactionAllowed (UserModel $payer, UserModel $payee, float $value) {
        $this->isUserAllowedToTransferMoney($payer);
        $this->isPayerBalanceSufficientForTransaction($payer, $value);
        $this->isPayerAndPayeeDifferent($payer, $payee);
    }

    private function isUserAllowedToTransferMoney (UserModel $user) {
        if (!$user->canTransferMoney()) {
            throw new \Exception('UserModel type is not allowed to perform transactions');
        }
    }

    private function isPayerBalanceSufficientForTransaction (UserModel $payer, float $value) {
        if ($payer->balance < $value) {
            throw new \Exception('Payer does not have enough balance');
        }
    }

    private function isPayerAndPayeeDifferent (UserModel $payer, UserModel $payee) {
        if ($payer->id === $payee->id) {
            throw new \Exception('Payer and payee cannot be the same user');
        }
    }
}