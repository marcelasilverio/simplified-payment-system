<?php

namespace App\Repositories\Payment;

use App\Repositories\Repository;
use App\Models\PaymentModel;

class PaymentRepository extends Repository
{
    public function __construct(PaymentModel $model)
    {
        parent::__construct(model: $model);
    }

    public function createPayment(PaymentModel $payment): bool
    {
        return $payment->save();
    }

    public function getPaymentById(int $id): ?PaymentModel
    {
        return $this->model::find(id: $id);
    }
}