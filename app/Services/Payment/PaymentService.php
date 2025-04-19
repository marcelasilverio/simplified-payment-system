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
    
    public function __construct(PaymentServiceValidator $validator, PaymentRepository $repository, NotificationServiceInterface $notificationService) {
        $this->notificationService = $notificationService;

        parent::__construct($repository, $validator);
    }
    
    public function createPayment(int $payerId, int $payeeId, float $value): PaymentModel
    {
        $payer = UserModel::find($payerId);
        $payee = UserModel::find($payeeId);
        $payment = new PaymentModel([
            'payer_id' => $payerId,
            'payee_id' => $payeeId,
            'value' => $value
        ]);
        $payment->setRelation('payer', $payer);
        $payment->setRelation('payee', $payee);
    
        $this->validator->validateCreation($payment);
        $this->repository->createPayment($payment);
        $this->notificationService->notifyUsers();

        $paymentCreated = $this->repository->getPaymentById($payment->id);

        PaymentCreatedEvent::dispatch($paymentCreated);

        return $paymentCreated;
    }
}