<?php

namespace App\Providers;

use App\Services\Auth\TwoFactorAuthGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('tfa', function ($app, $name, array $config) {
            return new TwoFactorAuthGuard($name, Auth::createUserProvider($config['provider']), $app['session.store']);
        });
    }
}
