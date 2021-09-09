<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ContactSaved;
use App\Mail\SendContactEmail as MailSendContactEmail;
use Illuminate\Support\Facades\Mail;

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
     * @param  App\Events\ContactSaved  $event
     * @return void
     */
    public function handle(ContactSaved $event)
    {
        $contact = $event->contact;

        // // Send email to admin
        Mail::to(config("mail.admin_email"))
            ->send(new MailSendContactEmail($contact));
    }


    public function failed(ContactSaved $event, $exception)
    {
        //
    }
}
