<?php

namespace App\Providers;

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
    public function boot()
    {
        // Menggunakan view composer untuk menyediakan data ke includes.nav-public
        view()->composer('includes.nav-public', function ($view) {
            $pages = \App\Models\Page::all(); // Ambil data halaman dari database
            $view->with('pages', $pages);
        });
    }
}
