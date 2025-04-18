<?php

namespace App\Services\ExternalApi;

use Illuminate\Support\Facades\Http;
use Exception;

class ExternalNotificationApiService
{
 protected string $baseUrl;

 public function __construct()
 {
     $this->baseUrl = config('services.externalNotificationApi.url');
 }
 
 public function notifyUsers(): bool
 {
     try {
         $response = Http::post($this->baseUrl . '/notify');

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