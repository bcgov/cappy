<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/debug-host', function () {
    dd([
        'host' => request()->getHost(),
        'scheme' => request()->getScheme(),
        'full_url' => request()->fullUrl(),
        'secure' => request()->isSecure(),
    ]);
});
