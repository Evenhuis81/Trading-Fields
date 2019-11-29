<?php

namespace App\Repositories;

use App\Advert;

class AdvertRepository
{
    public function admanAdverts() {
        return Advert::where('owner_id', (auth()->id()))->get();
    }
}