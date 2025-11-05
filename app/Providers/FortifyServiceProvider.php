<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\LogoutResponse;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind the login view response
        $this->app->bind(LoginViewResponse::class, function () {
            return new class implements LoginViewResponse {
                public function toResponse($request)
                {
                    return view('auth.login');
                }
            };
        });
    }

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email.$request->ip());
        });

        Gate::define('create-article', function ($user) {
            return true; // Adjust this condition based on your requirements
        });

        // Remove these as they're now handled by the response bindings
        // Fortify::loginView(function () {
        //     return view('auth.login');
        // });
        //
        // Fortify::registerView(function () {
        //     return view('auth.register');
        // });
    }
}
