<?php
// app/Providers/AuthServiceProvider.php

namespace App\Providers;

use App\Models\PoorFamily;
use App\Policies\PoorFamilyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        PoorFamily::class => PoorFamilyPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
        
        // Auto-discovery policies (Laravel 12 feature)
        Gate::guessPolicyNamesUsing(function (string $modelClass) {
            return 'App\\Policies\\' . class_basename($modelClass) . 'Policy';
        });
    }
}
