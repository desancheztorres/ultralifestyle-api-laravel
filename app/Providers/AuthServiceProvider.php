<?php

namespace App\Providers;

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
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Profile' => 'App\Policies\ProfilePolicy',
        'App\Models\Blog' => 'App\Policies\BlogPolicy',
        'App\Models\Post' => 'App\Policies\PostPolicy',
        'App\Models\Routine' => 'App\Policies\RoutinePolicy',
        'App\Models\Plan' => 'App\Policies\PlanPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
