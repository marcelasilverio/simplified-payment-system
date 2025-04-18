<?php

namespace App\Repositories\Payment;

use App\Repositories\Repository;
use App\Models\PaymentModel;

class PaymentRepository extends Repository 
{
    public function createPayment(PaymentModel $payment): PaymentModel
    {
        return $payment->save();
    }

    public function getPaymentById(int $id): ?PaymentModel
    {
        return PaymentModel::find($id);
    }
}