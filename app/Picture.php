<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    public function advert() {
        return $this->belongsTo(Advert::class, 'advert_id');
    }

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
