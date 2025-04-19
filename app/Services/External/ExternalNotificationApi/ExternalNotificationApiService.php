<?php

namespace App\Services\External\ExternalNotificationApi;

use Illuminate\Support\Facades\Http;
use App\Interfaces\NotificationServiceInterface;
use Illuminate\Support\Facades\Log;

use App\Exceptions\Notifications\NotificationErrorException;

class ExternalNotificationApiService implements NotificationServiceInterface
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config(key: 'services.externalNotificationApi.url');
    }

    public function notifyUsers(): void
    {
        try {
            $response = Http::post(url: $this->baseUrl . '/notify');

            if (!$response->status() === 204) {
                throw new NotificationErrorException();
            }
        } catch (\Exception $e) {
            Log::error(message: 'Notification error: ' . $e->getMessage());
        }
    }
}