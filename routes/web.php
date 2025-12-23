<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebugController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear-permission-cache', function() {
    app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    return 'Spatie permission cache cleared!';
});

Route::get('/debug-role-check', [DebugController::class, 'checkRole'])->middleware('web');