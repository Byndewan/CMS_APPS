<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('/modules', App\Http\Controllers\Admin\ModuleController::class, ['as' => 'admin']);

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');
    Route::get('/content/{module_slug}', [App\Http\Controllers\Admin\PostController::class, 'index'])->name('admin.content.index');
    Route::get('/content/{module_slug}/create', [App\Http\Controllers\Admin\PostController::class, 'create'])->name('admin.content.create');
    Route::post('/content/{module_slug}', [App\Http\Controllers\Admin\PostController::class, 'store'])->name('admin.content.store');
    Route::get('/content/{module_slug}/{id}/edit', [App\Http\Controllers\Admin\PostController::class, 'edit'])->name('admin.content.edit');
    Route::put('/content/{module_slug}/{id}', [App\Http\Controllers\Admin\PostController::class, 'update'])->name('admin.content.update');
    Route::delete('/content/{module_slug}/{id}', [App\Http\Controllers\Admin\PostController::class, 'destroy'])->name('admin.content.destroy');
    Route::get('/sections', [App\Http\Controllers\Admin\SectionController::class, 'index'])->name('admin.sections.index');
    Route::put('/sections/{id}', [App\Http\Controllers\Admin\SectionController::class, 'update'])->name('admin.sections.update');
    Route::post('/sections/reorder', [App\Http\Controllers\Admin\SectionController::class, 'reorder'])->name('admin.sections.reorder');
})->middleware(['auth', 'role:admin']);
