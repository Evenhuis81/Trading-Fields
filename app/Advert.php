<?php

namespace App;

use App\Bid;
use App\User;
use App\Picture;
use App\Category;
use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    protected $fillable = [
        'title', 'description', 'price', 'startbid', 'owner_id',
    ];

    public function pictures() {
        return $this->hasMany(Picture::class, 'advert_id');
    }

    public function categories() {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function owner() {
        return $this->belongsTo(User::class);
    }

    public function bids () {
        return $this->hasMany(Bid::class);
    }
}
