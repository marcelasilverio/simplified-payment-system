<?php

namespace App\Exceptions\Payment;

use Exception;
use Illuminate\Http\JsonResponse;

class SameUserPaymentException extends Exception
{
    protected const MESSAGE = "Payer and payee cannot be the same user";
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
