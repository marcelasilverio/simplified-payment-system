<?php

namespace App\Payment\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

use App\Models\UserModel;

use App\Exceptions\Payment\InsufficientBalanceForPaymentException;
use App\Exceptions\Payment\PaymentNotAllowedForUserTypeException;
use App\Exceptions\Payment\SameUserPaymentException;

class PaymentService
{
    public function createPayment(int $payerId, int $payeeId, float $value) {
        $payer = UserModel::find($payerId);
        $payee = UserModel::find($payeeId);

        $this->isPaymentAllowed($payer, $payee, $value);

        
    }

    private function isPaymentAllowed(UserModel $payer, UserModel $payee, float $value) {
        $this->isUserAllowedToTransferMoney($payer);
        $this->isPayerBalanceSufficientForTransaction($payer, $value);
        $this->isPayerAndPayeeDifferent($payer, $payee);
    }

    private function isUserAllowedToTransferMoney (UserModel $user) {
        if (!$user->canTransferMoney()) {
           throw new PaymentNotAllowedForUserTypeException();
        }
    }

    private function isPayerBalanceSufficientForTransaction (UserModel $payer, float $value) {
        if ($payer->balance < $value) {
            throw new InsufficientBalanceForPaymentException();
        }
    }

    private function isPayerAndPayeeDifferent (UserModel $payer, UserModel $payee) {
        if ($payer->id === $payee->id) {
            throw new SameUserPaymentException();
        }
    }
}