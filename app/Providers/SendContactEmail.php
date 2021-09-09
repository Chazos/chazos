<?php

namespace App\Providers;

use App\Providers\ContactSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendContactEmail implements ShouldQueue
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
     * @param  ContactSaved  $event
     * @return void
     */
    public function handle(ContactSaved $event)
    {
        //
    }
}
