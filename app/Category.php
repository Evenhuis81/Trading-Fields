<?php

namespace App;

use App\Advert;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function adverts() {
        return $this->belongsToMany(Advert::class)->withTimestamps();
    }
}
