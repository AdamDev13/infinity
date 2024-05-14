<?php

namespace App\Providers;

use App\Nova\Cards\CardProjectFavorites;
use App\Nova\Cards\CardProjectViews;
use App\Nova\Cards\CardSearchPreferences;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Ugduck\AdminDashboard\AdminDashboard;
use Ugduck\Infoclient\Infoclient;
use Wehaa\CustomLinks\CustomLinks;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // sort resources menu by priority order
    //    Nova::sortResourcesBy(function ($resource) {
    //        return $resource::$priority ?? 9999;
    //    });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        // vendor dashboard
        if(Auth::user()->hasRole("vendor")) {
            return [
                new CardProjectFavorites,
                new CardProjectViews,
                new CardSearchPreferences,
            ];
        }
        return [
//            new Help()
            new AdminDashboard()
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new CustomLinks(),
            new \Ugduck\Myprofile\Myprofile,
            new \Ugduck\ResetPassword\ResetPassword
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
