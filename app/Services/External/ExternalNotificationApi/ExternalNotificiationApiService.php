<?php

namespace App\Services\ExternalApi;

use Illuminate\Support\Facades\Http;

use App\Exceptions\NotificationErrorException;

class ExternalNotificationApiService
{
 protected string $baseUrl;

 public function __construct()
 {
     $this->baseUrl = config('services.externalNotificationApi.url');
 }
 
 public function notifyUsers()
 {
     try {
         $response = Http::post($this->baseUrl . '/notify');

         if (!$response->status() === 204) {
            throw new NotificationErrorException();
         }
     } catch (Exception $e) {
        Log::error('Notification error: ' . $e->getMessage());
     }
 }
}