<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\TransactionController;

Route::get('/', function () {
    return view('welcome');
});