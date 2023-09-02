<?php

namespace App\Providers;

use App\Events\CustomerRegistered;
use App\Listeners\SendCustomerConfirmationEmail;
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
        // CustomerRegistered::class => [
        //     SendCustomerConfirmationEmail::class,
        // ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
