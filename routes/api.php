<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\TransactionController;

Route::group(['prefix' => 'v1'], function () {
 Route::post('transfer', [TransactionController::class, 'post']);
});