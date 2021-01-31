<?php

namespace App\Providers;

use App\Support\Auth\AuthProviderFactory;
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
        $this->app->singleton(AuthProviderFactory::class, function ($app) {
            if (request()->hasHeader('provider')) {
                return (new AuthProviderFactory)->get();
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
