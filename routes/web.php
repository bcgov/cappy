<?php

use App\Livewire\Welcome;
use App\Livewire\Applications\Application;
use App\Livewire\Applications\CategoryList;
use App\Models\Enums\ApplicationCategory;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class);
Route::get('/applications/{application}', Application::class);
Route::get('/applications/category/{category}', CategoryList::class);
