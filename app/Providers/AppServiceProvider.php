<?php

namespace App\Providers;

use App\Models\MainCategory;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
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
        $this->app->bind(CartRepository::class, CartModelRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        require_once app_path('Helper/TextTranslate.php');

        // Register observers
        \App\Models\Order::observe(\App\Observers\OrderObserver::class);
        \App\Models\Company::observe(\App\Observers\CompanyObserver::class);

        Inertia::share([
            'categories' => fn() => MainCategory::select('id', 'name', 'name_en', 'slug', 'image')->get()->map(fn($c) => [
                'id'        => $c->id,
                'name'      => $c->name,
                'name_en'   => $c->name_en,
                'slug'      => $c->slug,
                'image_url' => $c->image ? asset('storage/' . $c->image) : null,
            ]),
            'auth' => fn() => [
                'user' => auth('web')->user() ? [
                    'id'          => auth('web')->user()->id,
                    'first_name'  => auth('web')->user()->first_name,
                    'family_name' => auth('web')->user()->family_name,
                    'email'       => auth('web')->user()->email,
                ] : null,
            ],
            'flash' => fn() => [
                'success' => session('success'),
                'error'   => session('error'),
            ],
        ]);
    }
}
