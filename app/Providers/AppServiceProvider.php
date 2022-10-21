<?php

namespace App\Providers;

use App\View\Composers\NavbarComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;

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
        View::composer('frontend.include.navbar', NavbarComposer::class);
        Schema::defaultStringLength(191);
        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });

    }
}
