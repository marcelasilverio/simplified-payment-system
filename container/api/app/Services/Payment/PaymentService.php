<?php

namespace App\Services\Payment;

use App\Models\UserModel;
use App\Models\PaymentModel;
use App\Services\Service;
use App\Validators\Payment\PaymentServiceValidator;
use App\Repositories\Payment\PaymentRepository;
use App\Events\PaymentCreatedEvent;
use App\Interfaces\NotificationServiceInterface;

class PaymentService extends Service
{
    private NotificationServiceInterface $notificationService;

    public function __construct(PaymentServiceValidator $validator, PaymentRepository $repository, NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;

        parent::__construct(repository: $repository, validator: $validator);
    }

    public function createPayment(int $payerId, int $payeeId, float $value): PaymentModel
    {
        $payer = UserModel::find(id: $payerId);
        $payee = UserModel::find(id: $payeeId);
        $payment = new PaymentModel(attributes: [
            'payer_id' => $payerId,
            'payee_id' => $payeeId,
            'value' => $value
        ]);
        $payment->setRelation(relation: 'payer', value: $payer);
        $payment->setRelation(relation: 'payee', value: $payee);

        $this->validator->validateCreation(data: $payment);
        $this->repository->createPayment(payment: $payment);
        $this->notificationService->notifyUsers();

        $paymentCreated = $this->repository->getPaymentById(id: $payment->id);

        PaymentCreatedEvent::dispatch($paymentCreated);

        return $paymentCreated;
    }
}