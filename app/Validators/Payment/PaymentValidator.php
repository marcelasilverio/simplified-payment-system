<?php

namespace App\Validators\Payment;  

use App\Models\UserModel;
use App\Services\Validator;

use App\Exceptions\Payment\InsufficientBalanceForPaymentException;
use App\Exceptions\Payment\PaymentNotAllowedForUserTypeException;
use App\Exceptions\Payment\SameUserPaymentException;

class PaymentServiceValidator extends Validator
{
    public function validateCreation(PaymentModel $payment) {
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