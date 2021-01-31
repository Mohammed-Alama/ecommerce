<?php

namespace App\Support\Auth;

use Illuminate\Support\Str;

class AuthProviderFactory
{
    private $provider;

    private $guard;

    private $model;

    private $scope;

    public function __construct()
    {
        $this->provider =  request()->header('provider');
    }

    public function get()
    {
        $this->setModel();
        $this->setGuard();
        $this->setScope();
        return $this;
    }

    public function getModel()
    {
        return app($this->model);
    }

    public function getGuard()
    {
        return $this->guard;
    }

    public function getProvider()
    {
        return $this->provider;
    }

    public function getScope()
    {
        return $this->scope;
    }

    public function getUser()
    {
        return request()->user($this->guard);
    }

    private function setModel()
    {
        $provider = $this->provider;
        $this->model = config("auth.providers.{$provider}.model");
    }

    private function setScope()
    {
        return $this->scope = Str::singular($this->provider);
    }

    private function setGuard()
    {
        $provider = $this->provider;
        if ($provider == 'users') {
            return $this->guard = 'api';
        }
        $guard_array = array_filter(
            config('auth.guards'),
            function ($value, $key) use ($provider) {
                return $value['provider'] == $provider;
            },
            ARRAY_FILTER_USE_BOTH
        );

        $this->guard = array_keys($guard_array)[0];
    }
}
