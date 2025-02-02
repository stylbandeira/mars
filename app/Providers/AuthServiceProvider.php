<?php

namespace App\Providers;

use App\Models\Role;
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
        \App\Models\MacAddress::class => \App\Policies\MacAddressPolicy::class,
        \App\Models\InternetAccess::class => \App\Policies\InternetAccessPolicy::class,
        \App\Models\PrintJob::class => \App\Policies\PrintJobPolicy::class,
        \App\Models\PrintAccount::class => \App\Policies\PrintAccountPolicy::class,
        \App\Models\FreePages::class => \App\Policies\FreePagesPolicy::class,
        \App\Models\LocalizationContribution::class => \App\Policies\LocalePolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Checkout::class => \App\Policies\CheckoutPolicy::class,
        \App\Models\Transaction::class => \App\Policies\TransactionPolicy::class,
        \App\Models\Fault::class => \App\Policies\FaultPolicy::class,
        \App\Models\EpistolaNews::class => \App\Policies\EpistolaPolicy::class,
        \App\Models\Router::class => \App\Policies\RouterPolicy::class,
        \App\Models\MrAndMissVote::class => \App\Policies\MrAndMissPolicy::class,
        \App\Models\CommunityService::class => \App\Policies\CommunityServicePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // Model-related policies, registering the contents of $this->policies
        $this->registerPolicies();
        // General policies without models
        $this->registerDocumentPolicies();
        $this->registerVerificationPolicies();

        Gate::define('is-collegist', function ($user) {
            return $user->isCollegist();
        });
        Gate::define('is-admin', function ($user) {
            return $user->isAdmin();
        });
    }

    public function registerPrintingPermissionHandlingPolicies()
    {
        Gate::define('print.print', function ($user) {
            return $user->hasRole(Role::PRINTER);
        });
    }

    public function registerDocumentPolicies()
    {
        Gate::define('document.status-certificate.viewAny', function ($user) {
            return $user->hasRole(Role::SECRETARY);
        });
        Gate::define('document.status-certificate', function ($user) {
            return $user->isCollegist() && $user->isActive();
        });
        Gate::define('document.register-statement', function ($user) {
            return $user->isCollegist()
                || $user->hasRole(Role::TENANT);
        });
        Gate::define('document.import-license', function ($user) {
            return $user->isCollegist()
                || $user->hasRole(Role::TENANT);
        });

        Gate::define('document.any', function ($user) {
            return Gate::any([
                'document.status-certificate.viewAny',
                'document.status-certificate',
                'document.register-statement',
                'document.import-license',
            ]);
        });
    }

    public function registerVerificationPolicies()
    {
        Gate::define('registration.handle', function ($user) {
            return $user->hasRole([Role::SYS_ADMIN, Role::STAFF]);
        });
    }
}
