<?php

namespace App\Interfaces;

interface PaymentAuthorizationServiceInterface
{
    public function isPaymentAuthorized(): bool;
}