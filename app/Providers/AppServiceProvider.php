<?php

namespace App\Providers;

use App\Models\UpdateProjectEmail;
use App\Observers\UpdateProjectEmailsObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        UpdateProjectEmail::observe(UpdateProjectEmailsObserver::class);
    }
}
