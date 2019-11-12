<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    // set fillable
    protected $fillable = [
        // 'file_name',
    ];

    public function advert() {
        return $this->belongsTo(Advert::class, 'advert_id');
    }

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // public function getFileNameAttribute($value)
    // { {file_name)}
    // file_name
    //     return "(&quot;data:image/jpeg;base64," . $value;
    // }
}
