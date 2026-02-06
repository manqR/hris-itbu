<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share organization context with all views
        view()->composer('*', function ($view) {
            if (auth()->check()) {
                $employee = auth()->user();
                // Eager load assignments to prevent N+1 queries
                $employee->loadMissing(['activeAssignments.organization']);

                if ($employee->activeAssignments->isNotEmpty()) {
                    $assignments = $employee->activeAssignments;
                    
                    // Get all accessible organizations
                    $accessibleOrganizations = $assignments->pluck('organization')->unique('id')->values();
                    
                    // Determine active organization
                    $activeOrganizationId = session('active_organization_id');
                    $activeOrganization = null;

                    if ($activeOrganizationId) {
                        $activeOrganization = $accessibleOrganizations->firstWhere('id', $activeOrganizationId);
                    }

                    // Fallback to primary assignment or first available organization
                    if (!$activeOrganization) {
                        $primaryAssignment = $assignments->firstWhere('is_primary', true);
                        $activeOrganization = $primaryAssignment ? $primaryAssignment->organization : $accessibleOrganizations->first();
                        
                        // Set session for consistency 
                        if ($activeOrganization) {
                            session(['active_organization_id' => $activeOrganization->id]);
                        }
                    }

                    $view->with('global_active_organization', $activeOrganization);
                    $view->with('global_user_organizations', $accessibleOrganizations);
                } else {
                    $view->with('global_active_organization', null);
                    $view->with('global_user_organizations', collect());
                }
            }
        });
    }
}
