<?php

namespace App\Providers;

use App\Events\EventProjectUpdated;
use App\Events\UserFavoriteProjectEvent;
use App\Listeners\SendProjectUpdatedNotification;
use App\Listeners\UserFavoriteProjectListener;
use App\Models\Project;
use App\Models\ProjectBid;
use App\Models\ProjectQuestion;
use App\Observers\ProjectObserver;
use App\Observers\ProjectQuestionObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        EventProjectUpdated::class => [
            SendProjectUpdatedNotification::class,
        ],
        UserFavoriteProjectEvent::class => [
            UserFavoriteProjectListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Project::observe(ProjectObserver::class);
        ProjectBid::observe(\App\Observers\ProjectBid::class);
        ProjectQuestion::observe(ProjectQuestionObserver::class);
    }
}
