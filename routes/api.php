<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\PaymentController;

Route::group(attributes: ['prefix' => 'v1'], routes: function (): void {
    Route::post(uri: 'transfer', action: [PaymentController::class, 'post']);
    Route::post(uri: 'payment', action: [PaymentController::class, 'post']); // @TODO: suggestion of endpoint name
});