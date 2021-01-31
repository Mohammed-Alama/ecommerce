<?php

use App\Support\Auth\AuthProviderFactory;
use Illuminate\Support\Facades\App;

if (!function_exists('auth_factory')) {
    /**
     * Undocumented function
     *
     * @param string $key user | model | guard | provider | scope
     * @return mixed
     */
    function auth_factory($key)
    {
        if ($key == 'model') {
            return App::make(AuthProviderFactory::class)->getModel();
        }
        if ($key == 'guard') {
            return App::make(AuthProviderFactory::class)->getGuard();
        }
        if ($key == 'provider') {
            return App::make(AuthProviderFactory::class)->getProvider();
        }
        if ($key == 'scope') {
            return App::make(AuthProviderFactory::class)->getScope();
        }
        if ($key == 'user') {
            return App::make(AuthProviderFactory::class)->getUser();
        }
    }
}
