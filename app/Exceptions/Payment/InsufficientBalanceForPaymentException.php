<?php

namespace App\Exceptions\Payment;

use Exception;

class InsufficientBalanceForPaymentException extends Exception
{
    protected const MESSAGE = "Insufficient balance for payment";
    protected const CODE = 400;

    public function __construct()
    {
        $this->message = self::MESSAGE;
        $this->code = self::CODE;
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->message,
        ], $this->code);
    }
}
