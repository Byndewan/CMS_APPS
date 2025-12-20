<?php

namespace App\Providers;

use App\Models\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('modules')) {
            View::composer('admin.*', function ($view) {
                $view->with('sidebar_modules', Module::where('is_active', 1)->get());
            });
        }
    }
}
