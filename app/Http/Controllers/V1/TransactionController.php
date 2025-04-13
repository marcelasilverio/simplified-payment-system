<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function post(Request $request) {
        return response()->json(['message' => 'Transfer successful'], 200);
    }
}
