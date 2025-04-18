<?php

namespace App\Payment\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

use App\Models\UserModel;
use App\Services\Service;
use App\Validators\Payment\PaymentServiceValidator;

use App\Exceptions\Payment\InsufficientBalanceForPaymentException;
use App\Exceptions\Payment\PaymentNotAllowedForUserTypeException;
use App\Exceptions\Payment\SameUserPaymentException;

class PaymentService extends Service
{
    public function __construct(PaymentServiceValidator $validator, PaymentRepository $repository) {
        parent::__construct($validator, $repository);
    }
    
    public function createPayment(int $payerId, int $payeeId, float $value) {
        $payer = UserModel::find($payerId);
        $payee = UserModel::find($payeeId);

        $payment = new PaymentModel([
            'payer' => $payer,
            'payee' => $payee,
            'value' => $value
        ]);
    
        $this->validator->validateCreation($payment);
        $this->repository->createPayment($payment);
    }
}