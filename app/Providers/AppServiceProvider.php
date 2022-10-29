<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $role = '';
            if (Auth::guard('admin')->check()) {
                $role = 'admin';
            } elseif (Auth::guard('moderator')->check()) {
                $role = 'moderator';
            }

            $view->with('role', $role);
        });
    }
}
