<?php

namespace App\Plugins\Chazol\Providers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\CustomAction;
use App\Plugins\Azol\Handlers\Listeners\ApproveClient;

class AzolEventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CustomAction::class => [
            ApproveClient::class,
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
