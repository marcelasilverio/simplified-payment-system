<?php

namespace App\Validators\Payment;  

use App\Validators\Validator;
use App\Models\UserModel;
use App\Models\PaymentModel;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\PaymentAuthorizationServiceInterface;
use App\Services\Payment\WalletService;

use App\Exceptions\Payment\InsufficientBalanceForPaymentException;
use App\Exceptions\Payment\PaymentNotAllowedForUserTypeException;
use App\Exceptions\Payment\PaymentAuthorizationServiceExceptionFailed;
use App\Exceptions\Payment\SameUserPaymentException;

class PaymentServiceValidator extends Validator
{
    private PaymentAuthorizationServiceInterface $paymentAuthorizationService;
    private WalletService $walletService;

    private PaymentModel $paymentModel;
    
    public function __construct(PaymentAuthorizationServiceInterface $paymentAuthorizationService, WalletService $walletService) {
        $this->walletService = $walletService;
        $this->paymentAuthorizationService = $paymentAuthorizationService;
    }


    public function validateCreation(Model $payment) {
        $this->setPaymentModel($payment);

        $this->checkIfUserAllowedToTransferMoney($this->payment->payer);
        $this->checkIfPayerBalanceIsSufficientForTransaction($this->payment->payer, $this->payment->value);
        $this->checkIfPayerAndPayeeDifferent($this->payment->payer, $this->payment->payee);
        $this->checkIfExternalAuthorizationServiceAllow($this->payment->payer, $this->payment->payee, $this->payment->value);
    }

    private function setPaymentModel(Model $paymentModel) {
        if (!($paymentModel instanceof PaymentModel)) {
            throw new \InvalidArgumentException('Invalid payment model provided');
        }

        $this->paymentModel = $paymentModel;
    }

    private function checkIfUserAllowedToTransferMoney (UserModel $user) 
    {
        if (!$user->canTransferMoney()) {
           throw new PaymentNotAllowedForUserTypeException();
        }
    }

    private function checkIfPayerBalanceIsSufficientForTransaction (UserModel $payer, double $value) 
    {
        if ($walletService->getUserBalance($payer) < $value) {
            throw new InsufficientBalanceForPaymentException();
        }
    }

    private function checkIfPayerAndPayeeDifferent (UserModel $payer, UserModel $payee) 
    {
        if ($payer->id === $payee->id) {
            throw new SameUserPaymentException();
        }
    }

    private function checkIfExternalAuthorizationServiceAllow()
    {
        if (!$this->paymentAuthorizationService->isPaymentAuthorized()) {
            throw new PaymentAuthorizationServiceExceptionFailed();
        }
    }
}