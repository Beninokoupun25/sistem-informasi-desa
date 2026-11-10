<?php

namespace App\Providers;

use App\Models\Desa;
use App\Models\User;
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
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('create-desa', function (User $user) {
            // Role tunggal: super_admin — akses lintas desa.
            return $user->status === 'aktif';
        });

        Gate::define('manage-desa', function (User $user, Desa $desa) {
            return $user->status === 'aktif';
        });
    }
}
