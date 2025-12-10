<?php

use App\Http\Controllers\Api\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('applications', ApplicationController::class);
});
