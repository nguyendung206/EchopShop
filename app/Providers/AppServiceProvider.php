<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Banner;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('MyTesting', function($app) {
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
        $categories =  Category::query()->where('status', 1)->with('brands')->limit(9)->get();
        $banners = Banner::query()->where('status', 1)->orderBy('display_order', 'asc')->limit(4)->get();
        View::share('categories', $categories);
        View::share('banners', $banners);
    }
}
