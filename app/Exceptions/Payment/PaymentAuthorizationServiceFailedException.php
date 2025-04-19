<?php

namespace App\Exceptions\Payment;

use Exception;
use Illuminate\Http\JsonResponse;

class PaymentAuthorizationServiceFailedException extends Exception
{
    protected const MESSAGE = "Payment not authorized by the external service.";
    protected const CODE = 400;

    public function __construct()
    {
        $this->message = self::MESSAGE;
        $this->code = self::CODE;
    }

    public function render(): JsonResponse
    {
        return response()->json(data: [
            'error' => $this->message,
        ], status: $this->code);
    }
}
