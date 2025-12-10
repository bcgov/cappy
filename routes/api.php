<?php

use App\Http\Controllers\Api\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/applications', [ApplicationController::class, 'index'])
    ->middleware(['auth:sanctum', 'ability:admin']);
