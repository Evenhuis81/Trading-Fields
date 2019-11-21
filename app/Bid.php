<?php

namespace App;

use App\User;
use App\Advert;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = [
        'advert_id', 'value', 'owner_id',
    ];


    public function advert()
    {
        return $this->belongsTo(Advert::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
