<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Interaction;
use App\Models\Project;
use App\Policies\CustomerPolicy;
use App\Policies\InteractionPolicy;
use App\Policies\ProjectPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Customer::class => CustomerPolicy::class,
        Project::class => ProjectPolicy::class,
        Interaction::class => InteractionPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
