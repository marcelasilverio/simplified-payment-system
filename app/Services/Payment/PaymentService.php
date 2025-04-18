<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

use App\Models\UserModel;
use App\Models\PaymentModel;
use App\Services\Service;
use App\Validators\Payment\PaymentServiceValidator;
use App\Repositories\Payment\PaymentRepository;
use App\Events\PaymentCreatedEvent;
use App\Interfaces\NotificationServiceInterface;

use App\Exceptions\Payment\InsufficientBalanceForPaymentException;
use App\Exceptions\Payment\PaymentNotAllowedForUserTypeException;
use App\Exceptions\Payment\SameUserPaymentException;

class PaymentService extends Service
{
    private NotificationServiceInterface $notificationService;
    
    public function __construct(PaymentServiceValidator $validator, PaymentRepository $repository, NotificiationServiceInterface $notificationService) {
        $this->notificationService = $notificationService;

        parent::__construct($repository, $validator);
    }
    
    public function createPayment(int $payerId, int $payeeId, double $value) {
        $payer = UserModel::find($payerId);
        $payee = UserModel::find($payeeId);

        $payment = new PaymentModel([
            'payer' => $payer,
            'payee' => $payee,
            'value' => $value
        ]);
    
        $this->validator->validateCreation($payment);
        $this->repository->createPayment($payment);
        $this->notificationService->notifyUsers();

        PaymentCreatedEvent::dispatch($payment);
    }
}