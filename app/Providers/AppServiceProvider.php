<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Fortify::loginView(function () {
            return view('auth.register');
        });
    }

    public function boot(): void
    {
        Fortify::loginView(function () {
            return view('auth.login');
        });
    }
}
