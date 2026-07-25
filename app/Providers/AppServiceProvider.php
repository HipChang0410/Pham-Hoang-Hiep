<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
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
        Paginator::useBootstrapFive();
        // Provide categories and brands to the client header/navbar via view composer
        View::composer('client.partials.header', function ($view) {
            $categories = Cache::store('file')->remember('navbar_categories', now()->addHours(1), function () {
                return Category::select('id', 'catename', 'slug')
                    ->where('status', 1)
                    ->orderBy('catename')
                    ->take(20)
                    ->get();
            });

            $brands = Cache::store('file')->remember('navbar_brands', now()->addHours(1), function () {
                return Brand::select('id', 'brandname', 'slug')
                    ->where('status', 1)
                    ->orderBy('brandname')
                    ->take(20)
                    ->get();
            });

            $view->with(compact('categories', 'brands'));
        });
    }
}
