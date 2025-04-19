<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\PaymentController;

Route::group(['prefix' => 'v1'], function () {
 Route::post('transfer', [PaymentController::class, 'post']);
 Route::post('payment', [PaymentController::class, 'post']); // @TODO: suggestion of endpoint name
});