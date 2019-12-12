<?php

namespace App\Listeners;

use App\Events\AdvertCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAdvertCreatedNotification
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
     * @param  AdvertCreated  $event
     * @return void
     */
    public function handle(AdvertCreated $event)
    {
        dd('sended advert created notification');
    }
}
