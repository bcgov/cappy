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

Route::get('/debug-session', function() {
    $user = auth()->user();
    return response()->json([
        'authenticated' => auth()->check(),
        'user' => $user ? [
            'id' => $user->id,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'roles' => $user->getRoleNames(),
        ] : null,
        'session_id' => session()->getId(),
        'session_data' => session()->all(),
        'cookies' => request()->cookies->all(),
        'app_env' => config('app.env'),
        'session_config' => [
            'driver' => config('session.driver'),
            'domain' => config('session.domain'),
            'secure' => config('session.secure'),
            'same_site' => config('session.same_site'),
        ],
    ]);
})->middleware('web');