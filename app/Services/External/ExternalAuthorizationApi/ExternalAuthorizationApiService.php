<?php

namespace App\Services\External\ExternalAuthorizationApi;

use Illuminate\Support\Facades\Http;
use Exception;

use \App\Interfaces\PaymentAuthorizationServiceInterface;

class ExternalAuthorizationApiService implements PaymentAuthorizationServiceInterface
{
 protected string $baseUrl;

    public function __construct() 
    {
        $this->baseUrl = config('services.externalAuthorizationApi.url');
    }
 
    public function isPaymentAuthorized(): bool
    {
        try {
            $response = Http::get($this->baseUrl . '/authorize');

            if ($response->status() === 200) {
                $returnedData = $response->json();
                return $returnedData['authorized'] === "true";
            }

        } catch (Exception $e) {
           return false;
        }

        return false;
    }
}