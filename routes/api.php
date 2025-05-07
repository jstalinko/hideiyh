<?php

use App\Http\Controllers\LinkApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/link/{apikey}' , [LinkApiController::class,'index'])->name('link.index');
Route::get('/validate-visitor/{apikey}',[LinkApiController::class , 'engine'])->name('link.engine');