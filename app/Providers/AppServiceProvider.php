<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
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
        View::composer('layouts.header', function ($view) {
            $unreadNotifications = collect();
            $notifications = collect();

            if (Auth::check()) {
                $unreadNotifications = Auth::user()->unreadNotifications;
                $notifications = Auth::user()->notifications()->take(10)->get();
            }

            $view->with([
                'unreadNotifications' => $unreadNotifications,
                'notifications' => $notifications,
            ]);
        });
    }
}
