<?php

use App\Http\Controllers\BlynkDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/blynk-data', [BlynkDataController::class, 'store']);