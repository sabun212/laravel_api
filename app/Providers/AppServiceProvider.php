<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;
use App\Models\Sanctum\PersonalAccessToken;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Gate::define('admin', function(User $user){
            return $user->is_admin;
        });
    }

    // public function boot()
    // {
    //     Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    // }

}
