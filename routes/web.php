<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('home');
Route::get('/detail/{slug}', [App\Http\Controllers\FrontController::class, 'show'])->name('front.post.show');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('/modules', App\Http\Controllers\Admin\ModuleController::class, ['as' => 'admin']);
Route::get('/menu/{slug}', [App\Http\Controllers\FrontController::class, 'category'])->name('front.category');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');
    Route::get('/content/{module_slug}', [App\Http\Controllers\Admin\PostController::class, 'index'])->name('admin.content.index');
    Route::get('/content/{module_slug}/create', [App\Http\Controllers\Admin\PostController::class, 'create'])->name('admin.content.create');
    Route::post('/content/{module_slug}', [App\Http\Controllers\Admin\PostController::class, 'store'])->name('admin.content.store');
    Route::get('/content/{module_slug}/{id}/edit', [App\Http\Controllers\Admin\PostController::class, 'edit'])->name('admin.content.edit');
    Route::put('/content/{module_slug}/{id}', [App\Http\Controllers\Admin\PostController::class, 'update'])->name('admin.content.update');
    Route::delete('/content/{module_slug}/{id}', [App\Http\Controllers\Admin\PostController::class, 'destroy'])->name('admin.content.destroy');
    Route::get('/sections', [App\Http\Controllers\Admin\SectionController::class, 'index'])->name('admin.sections.index');
    Route::post('/sections', [App\Http\Controllers\Admin\SectionController::class, 'store'])->name('admin.sections.store');
    Route::put('/sections/{id}', [App\Http\Controllers\Admin\SectionController::class, 'update'])->name('admin.sections.update');
    Route::delete('/sections/{id}', [App\Http\Controllers\Admin\SectionController::class, 'destroy'])->name('admin.sections.destroy');
    Route::post('/sections/reorder', [App\Http\Controllers\Admin\SectionController::class, 'reorder'])->name('admin.sections.reorder');
})->middleware(['auth', 'role:admin']);
