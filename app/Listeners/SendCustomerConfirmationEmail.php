<?php

namespace App\Listeners;

use App\Mail\ConfirmationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCustomerConfirmationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // Send the confirmation email asynchronously
        Mail::to($event->customerRequest->email)->send(new ConfirmationEmail($event));
    }
}
