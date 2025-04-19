<?php

namespace App\Exceptions\Payment;

use Exception;
use Illuminate\Http\JsonResponse;

class PaymentNotAllowedForUserTypeException extends Exception
{
    protected const MESSAGE = "Payment not allowed for this user type";
    protected const CODE = 400;

    public function __construct()
    {
        $this->message = self::MESSAGE;
        $this->code = self::CODE;
    }

    public function render(): JSONResponse
    {
        return response()->json(data: [
            'error' => $this->message,
        ], status: $this->code);
    }
}
