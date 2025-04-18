<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\PaymentRequest;
use App\Http\Controllers\Controller;
use App\Business\PaymentBusiness;
use App\Models\UserModel;    

class PaymentController extends Controller
{
    protected PaymentBusiness $paymentBusiness;

    public function __construct(paymentBusiness $paymentBusiness) {
        $this->paymentBusiness = new paymentBusiness();
    }

    public function post(PaymentRequest $request) {
        $validatedData = $request->validated();

        $payerId = $validatedData['payer'];
        $payeeId = $validatedData['payee'];
        $value = $validatedData['value'];

        try {
            $this->paymentBusiness->transfer($payerId, $payeeId, $value);
            return response()->json(['message' => 'Transaction successful'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
        
    }
}
