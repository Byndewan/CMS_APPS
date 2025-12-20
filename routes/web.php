<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/admin/dashboard', function () {
    return "<h1>Selamat Datang di Dashboard ".Auth::guard('web')->user()->name."! </h1> <form action='/logout' method='POST'>" . csrf_field() . "<button type='submit'>Logout</button></form>";
})->middleware('auth');
