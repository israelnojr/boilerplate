<?php

namespace boxe\Providers;

use Laravel\Passport\Passport;
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
        // 'boxe\Model' => 'boxe\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function($user){
            return $user->type === 'admin';
        });

        Gate::define('isAuthor', function($user){
            return $user->type === 'author';
        });

        Gate::define('isUser', function($user){
            return $user->type === 'user';
        });

        Gate::define('isDeveloper', function($user){
            return $user->type === 'developer';
        });

        Gate::define('isDisabled', function($user){
            return $user->type === 'disable';
        });
        
        Passport::routes();
    }
}
