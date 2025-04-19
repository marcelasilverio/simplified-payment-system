<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\PaymentRequest;
use App\Http\Controllers\Controller;
use App\Services\Payment\PaymentService;
use App\Models\UserModel;    

class PaymentController extends Controller
{
    public function __construct(PaymentService $paymentService) {
        parent::__construct($paymentService);
    }

    public function post(PaymentRequest $request) {
        $validatedData = $request->validated();

        $payerId = $validatedData['payer'];
        $payeeId = $validatedData['payee'];
        $value = $validatedData['value'];

        try {
            $paymentCreated = $this->service->createPayment($payerId, $payeeId, $value);
            return response()->json($paymentCreated, 201);
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 400);
        }
        
    }
}
