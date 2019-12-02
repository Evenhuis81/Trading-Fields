<?php

namespace App\Repositories;

use App\Advert;
use App\User;
use App\Repositories\Interfaces\AdvertRepositoryInterface;

class AdvertRepository implements AdvertRepositoryInterface
{
    public function all()
    {
        return Advert::all();
    }

    public function getByUser()
    {
        return Advert::where('owner_id', auth()->id())->get();
    }
}