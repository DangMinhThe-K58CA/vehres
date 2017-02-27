<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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

        //Allow joining to system if account had been activated.
        Gate::define('join-system', function($user) {
            return $user->status;
        });

        //Allow access to admin site if user is administration.
        Gate::define('is-admin', function($user) {
            return $user->role === 3;
        });

        //Allow access to partner site if user is partner.
        Gate::define('is-partner', function($user) {
            return $user->role === 2;
        });

        //Check general user.
        Gate::define('is-general-user', function($user) {
            return $user->role === 1;
        });
    }
}
