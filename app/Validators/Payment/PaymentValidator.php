<?php

namespace App\Validators\Payment;  

use App\Models\UserModel;
use App\Services\Validator;
use App\Interfaces\PaymentAuthorizationServiceInterface;

use App\Exceptions\Payment\InsufficientBalanceForPaymentException;
use App\Exceptions\Payment\PaymentNotAllowedForUserTypeException;
use App\Exceptions\Payment\PaymentAuthorizationServiceExceptionFailed;
use App\Exceptions\Payment\SameUserPaymentException;

class PaymentServiceValidator extends Validator
{
    private PaymentAuthorizationServiceInterface $paymentAuthorizationService;
    private WalletService $walletService;
    
    public function __construct(PaymentAuthorizationServiceInterface $paymentAuthorizationService, WalletService $walletService) {
        $this->walletService = $walletService;
        $this->paymentAuthorizationService = $paymentAuthorizationService;

        parent::__construct();
    }

    public function validateCreation(PaymentModel $payment) {
        $this->checkIfUserAllowedToTransferMoney($payer);
        $this->checkIfPayerBalanceIsSufficientForTransaction($payer, $value);
        $this->checkIfPayerAndPayeeDifferent($payer, $payee);
        $this->checkIfExternalAuthorizationServiceAllow($payer, $payee, $value);
    }

    private function checkIfUserAllowedToTransferMoney (UserModel $user) 
    {
        if (!$user->canTransferMoney()) {
           throw new PaymentNotAllowedForUserTypeException();
        }
    }

    private function checkIfPayerBalanceIsSufficientForTransaction (UserModel $payer, float $value) 
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