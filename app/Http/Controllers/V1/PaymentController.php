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
            $this->service->createPayment($payerId, $payeeId, $value);
            return response()->json(['message' => 'Transaction successful'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
        
    }
}
