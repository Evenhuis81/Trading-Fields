<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdvertCreated
{
    use Dispatchable, SerializesModels;

    public $advert;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($advert)
    {
        $this->advert = $advert;
    }
}
