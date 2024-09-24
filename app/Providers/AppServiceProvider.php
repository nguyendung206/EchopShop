<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Province;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('MyTesting', function ($app) {
            return new \App\Test;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('categories')) {
            $categories = Category::query()->where('status', 1)->with('activeBrands')->get();
            $provinces = Province::query()->get();
            View::share(['categories' => $categories,
                'provinces' => $provinces,
            ]);
        }
    }
}
