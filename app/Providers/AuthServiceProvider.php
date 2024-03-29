<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function ($user){
           return $user->hasRole('admin');
        });

        Gate::define('managing_partner', function ($user){
            return $user->hasAnyRole(['admin', 'managing_partner']);
        });

        Gate::define('staff', function ($user){
            return $user->hasAnyRole(['admin', 'managing_partner', 'staff']);
        });

        Gate::define('user', function ($user){
            return null !== User::find($user->id);
        });
    }
}
