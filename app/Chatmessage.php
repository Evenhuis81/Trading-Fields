<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chatmessage extends Model
{
    protected $fillable = ['message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
