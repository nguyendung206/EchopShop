<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Favorite;
use App\Models\Notification;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;
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
            View::share([
                'categories' => $categories,
                'provinces' => $provinces,
            ]);
        }
        if (Schema::hasTable('notifications')) {
            View::composer('*', function ($view) {
                if (Auth::check()) {
                    $notifications = Notification::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->limit(20)
                        ->get();

                    $view->with('notifications', $notifications);
                }
            });
        }
        if (Schema::hasTable('favorites')) {
            View::composer('*', function ($view) {
                if (Auth::check()) {
                    $favorites = Favorite::where('user_id', Auth::id())->get();
                    $view->with('favorites', $favorites);
                }
            });
        }
    }
}
