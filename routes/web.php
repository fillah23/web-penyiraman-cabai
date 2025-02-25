<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BlynkDataController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/monitoring', function () {
    return view('monitoring');
});
Route::get('/prediksi-penyiraman', [BlynkDataController::class, 'index'])->name('blynk-data.index');

Route::resource('users', UserController::class);
Route::get('/', function () {
    return redirect()->route('login');
});

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');
