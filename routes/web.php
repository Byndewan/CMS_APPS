<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');
    Route::get('/content/{module_slug}', [App\Http\Controllers\Admin\PostController::class, 'index'])->name('admin.content.index');
    Route::get('/content/{module_slug}/create', [App\Http\Controllers\Admin\PostController::class, 'create'])->name('admin.content.create');
    Route::post('/content/{module_slug}', [App\Http\Controllers\Admin\PostController::class, 'store'])->name('admin.content.store');
})->middleware(['auth', 'role:admin']);
