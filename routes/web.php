<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/debug-host', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'host' => $request->getHost(),
        'server' => $request->server(),
        'headers' => $request->headers->all(),
        'ip' => $request->ip(),
        'env_app_url' => env('APP_URL'),
        'resolved_url' => url('/'),
    ]);
});
