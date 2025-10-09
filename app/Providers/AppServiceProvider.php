<?php

namespace App\Providers;

use App\Models\MainCategory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        Paginator::useBootstrapFive();
        require_once app_path('Helper/TextTranslate.php');

        Inertia::share([
            'categories' => fn() => MainCategory::select('id', 'name', 'slug')->get(),
        ]);
    }
}
