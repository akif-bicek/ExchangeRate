<?php

namespace App\Http\Controllers;

use App\Libraries\Response;
use \App\Http\Resources\ExchangeRate;
use Illuminate\Support\Facades\Log;
use \Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
    public function index(Request $request)
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/api.log'),
        ])->info(
            '/exchange-rate: The user named "'. $request->user()->name .'" has access to the exchange rate API.'
            . 'User Email :' . $request->user()->email . 'User ID :' . $request->user()->id,
        );
        return Response::out(
            data: new ExchangeRate(\App\Models\ExchangeRate::all())
        );
    }
}
