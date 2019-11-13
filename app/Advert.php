<?php

namespace App;

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
}
