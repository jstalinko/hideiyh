<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HiController;
use App\Http\Controllers\EngineController;

Route::get('/', [HiController::class , 'home'])->name('home');
Route::get('/s/{slug}', EngineController::class);
