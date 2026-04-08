<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $this->discoverFilamentPolicies();
    }


    protected function discoverFilamentPolicies()
    {
        $resourcePath = app_path('Filament/Resources');

        if (!is_dir($resourcePath)) {
            return;
        }

        foreach (glob($resourcePath . '/*/Policy/*Policy.php') as $policyFile) {
            $relativePath = str_replace([app_path(), '.php', '/'], ['', '', '\\'], $policyFile);
            $policyClass = 'App' . $relativePath;

            // Extract model name from policy path
            preg_match('/Resources\\\\(.+?)\\\\Policy/', $policyClass, $matches);
            if (isset($matches[1])) {
                $modelClass = "App\\Filament\\Resources\\{$matches[1]}\\Model\\{$matches[1]}";

                if (class_exists($modelClass) && class_exists($policyClass)) {
                    Gate::policy($modelClass, $policyClass);
                }
            }
        }
    }

}
