<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'value' => 'required|numeric',
            'payer' => 'required|exists:users,id',
            'payee' => 'required|exists:users,id',
        ];
    }
}
