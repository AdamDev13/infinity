<?php

namespace App\Providers;

use App\Models\Admin;
use App\Policies\UserPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
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
        //    Admin::class => AdminPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });

        ResetPassword::createUrlUsing(function ($user, string $token) {
            if ($user->hasRole('vendor')) {
                return url('/forgot-password/' . $token."/".$user->email);
            } else {
                return url('/users/reset-password?token=' . $token);
            }
        });
    }
}
