<?php

namespace App\Providers;

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
        'App\Advert' => 'App\Policies\AdvertPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('viewWebSocketsDashboard', function ($user) {
        //     // if $user = null, autofalse
        //     if ($user->isAdmin) {
        //         return in_array($user->isAdmin, [
        //             true,
        //         ]);
        //     } elseif ($user->isAdman) {
        //         return in_array($user->isAdman, [
        //             true,
        //         ]);
        //     } else {
        //         return false;
        //     };
        // });
    }
}
