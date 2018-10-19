<?php

namespace App\Providers;

use App\FileUser;
use App\Providers\FileUserProvider;
use App\Services\FileGuard;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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

		$this->app->bind('App\FileUser', function ($app) {
			return new FileUser();
		});

		// add custom guard provider
		Auth::provider('fileUser', function ($app, array $config) {
			return new FileUserProvider($app->make('App\FileUser'));
		});

		// add custom guard
		Auth::extend('file', function ($app, $name, array $config) {
			return new FileGuard(Auth::createUserProvider($config['provider']), $app->make('request'));
		});
    }
}
