<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\PaymentRequest;
use App\Http\Controllers\Controller;
use App\Services\Payment\PaymentService;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function __construct(PaymentService $paymentService)
    {
        parent::__construct(service: $paymentService);
    }

    public function post(PaymentRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $payerId = $validatedData['payer'];
        $payeeId = $validatedData['payee'];
        $value = $validatedData['value'];

        try {
            $paymentCreated = $this->service->createPayment(payerId: $payerId, payeeId: $payeeId, value: $value);
            return response()->json(data: $paymentCreated, status: 201);
        } catch (\Exception $error) {
            return response()->json(data: ['error' => $error->getMessage()], status: 400);
        }
    }
}
