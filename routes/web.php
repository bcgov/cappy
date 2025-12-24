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

Route::get('/debug-filament', function() {
    $user = auth()->user();
    $panel = \Filament\Facades\Filament::getCurrentOrDefaultPanel();

    $canAccess = false;
    $canAccessError = null;
    try {
        $canAccess = $user ? $user->canAccessPanel($panel) : false;
    } catch (\Exception $e) {
        $canAccessError = $e->getMessage();
    }

    // Test Spatie permissions
    $hasRoleAdmin = null;
    $hasRoleError = null;
    $roleNames = null;
    $permissionCacheKey = null;

    if ($user) {
        try {
            $hasRoleAdmin = $user->hasRole('admin');
            $roleNames = $user->getRoleNames()->toArray();
        } catch (\Exception $e) {
            $hasRoleError = $e->getMessage();
        }

        try {
            $permissionCacheKey = config('permission.cache.key');
            $cachedPermissions = \Cache::get($permissionCacheKey);
        } catch (\Exception $e) {
            $cachedPermissions = 'Error: ' . $e->getMessage();
        }
    }

    return response()->json([
        'user_authenticated' => auth()->check(),
        'user_id' => $user?->id,
        'user_email' => $user?->email,
        'panel_id' => $panel->getId(),
        'panel_path' => $panel->getPath(),
        'can_access_panel' => $canAccess,
        'can_access_error' => $canAccessError,
        'email_verification_required' => method_exists($panel, 'hasEmailVerification') ? $panel->hasEmailVerification() : 'unknown',
        'user_email_verified' => $user?->email_verified_at ? true : false,
        'spatie_permissions' => [
            'has_role_admin' => $hasRoleAdmin,
            'role_names' => $roleNames,
            'has_role_error' => $hasRoleError,
            'cache_key' => $permissionCacheKey,
            'cached_permissions_exist' => isset($cachedPermissions),
        ],
    ]);
})->middleware('web');

Route::get('/debug-session', function() {
    $user = auth()->user();

    // Check if sessions table exists
    $sessionTableExists = false;
    $sessionCount = null;
    try {
        $sessionCount = \DB::table('sessions')->count();
        $sessionTableExists = true;
    } catch (\Exception $e) {
        $sessionTableExists = false;
    }

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
        'database_check' => [
            'sessions_table_exists' => $sessionTableExists,
            'sessions_count' => $sessionCount,
        ],
    ]);
})->middleware('web');