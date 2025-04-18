<?php

namespace App\Exceptions\Payment;

use Exception;

class SameUserPaymentException extends Exception
{
    protected const MESSAGE = "Payer and payee cannot be the same user";
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
