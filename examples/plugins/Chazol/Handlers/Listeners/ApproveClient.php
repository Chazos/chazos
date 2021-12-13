<?php

namespace App\Plugins\Chazol\Handlers\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\CustomAction;
use Illuminate\Support\Facades\Mail;

class ApproveClient implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  App\Events\CustomAction  $event
     * @return void
     */
    public function handle(CustomAction $event)
    {

    }


    public function failed(CustomAction $event, $exception)
    {
        //
    }
}
