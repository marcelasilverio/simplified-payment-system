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
use App\Exceptions\Payment\PaymentAuthorizationServiceFailedException;
use App\Exceptions\Payment\SameUserPaymentException;

class PaymentServiceValidator extends Validator
{
    private PaymentAuthorizationServiceInterface $paymentAuthorizationService;
    private WalletService $walletService;

    private PaymentModel $payment;

    public function __construct(PaymentAuthorizationServiceInterface $paymentAuthorizationService, WalletService $walletService)
    {
        $this->walletService = $walletService;
        $this->paymentAuthorizationService = $paymentAuthorizationService;
    }


    public function validateCreation(Model $payment): void
    {
        $this->setPayment(payment: $payment);

        $this->checkIfUserAllowedToTransferMoney(user: $this->payment->payer);
        $this->checkIfPayerBalanceIsSufficientForTransaction(payer: $this->payment->payer, value: $this->payment->value);
        $this->checkIfPayerAndPayeeDifferent(payer: $this->payment->payer, payee: $this->payment->payee);
        $this->checkIfExternalAuthorizationServiceAllow($this->payment->payer, $this->payment->payee, $this->payment->value);
    }

    private function setPayment(Model $payment): void
    {
        if (!($payment instanceof PaymentModel)) {
            throw new \InvalidArgumentException(message: 'Invalid payment model provided');
        }

        $this->payment = $payment;
    }

    private function checkIfUserAllowedToTransferMoney(UserModel $user): void
    {
        if (!$user->canTransferMoney()) {
            throw new PaymentNotAllowedForUserTypeException();
        }
    }

    private function checkIfPayerBalanceIsSufficientForTransaction(UserModel $payer, float $value): void
    {
        if ($this->walletService->getUserBalance(user: $payer) < $value) {
            throw new InsufficientBalanceForPaymentException();
        }
    }

    private function checkIfPayerAndPayeeDifferent(UserModel $payer, UserModel $payee): void
    {
        if ($payer->id === $payee->id) {
            throw new SameUserPaymentException();
        }
    }

    private function checkIfExternalAuthorizationServiceAllow(): void
    {
        if (!$this->paymentAuthorizationService->isPaymentAuthorized()) {
            throw new PaymentAuthorizationServiceFailedException();
        }
    }
}