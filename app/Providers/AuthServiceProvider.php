<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Garage;
use App\Policies\ArticlePolicy;
use App\Policies\CommentPolicy;
use App\Policies\GaragePolicy;
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
        Comment::class => CommentPolicy::class,
        Garage::class => GaragePolicy::class,
        Article::class => ArticlePolicy::class,
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
            if ($user->status === config('common.user.status.unactivated')) {
                return 0;
            }

            return 1;
        });

        //Allow access to admin site if user is administration.
        Gate::define('is-admin', function($user) {
            return $user->role === config('common.user.role.admin');
        });

        //Allow access to partner site if user is partner.
        Gate::define('is-partner', function($user) {
            return $user->role === config('common.user.role.partner');
        });

        //Check general user.
        Gate::define('is-general-user', function($user) {
            return $user->role === config('common.user.role.user');
        });
    }
}
