<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebugController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug-role-check', [DebugController::class, 'checkRole'])->middleware('web');
