<?php

namespace App\Providers;

use App\Events\NotificationSent;
use App\Events\SensorDataUpdated;
use App\Listeners\NotificationSentListener;
use App\Listeners\SensorDataUpdatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        SensorDataUpdated::class => [
            SensorDataUpdatedListener::class
        ],
        NotificationSent::class => [
            NotificationSentListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
