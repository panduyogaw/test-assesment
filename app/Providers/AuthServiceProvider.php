<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use App\Models\User;
use App\Policies\TaskPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Task::class => TaskPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
{
    $this->registerPolicies();

    Gate::define('view-users', function (User $user) {
        return in_array($user->role, ['admin', 'manager']);
    });

    Gate::define('create-users', function (User $user) {
        return $user->role === 'admin';
    });

    Gate::define('view-logs', function (User $user) {
        return $user->role === 'admin';
    });
}
}
