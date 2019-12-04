<?php

namespace App;

use App\Bid;
use App\Pp4;
use App\User;
use App\Picture;
use App\Category;
use App\Delivery;
use App\Condition;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\Viewable;
use CyrildeWit\EloquentViewable\Contracts\Viewable as ViewableContract;

class Advert extends Model implements ViewableContract
{
    use Viewable;

    protected $fillable = [
        'title', 'description', 'condition', 'price', 'startbid', 'delivery', 'name', 'phonenr', 'zipcode', 'owner_id',
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

    public function condition() {
        return $this->belongsTo(Condition::class);
    }

    public function delivery() {
        return $this->belongsTo(Delivery::class);
    }

    public function hometown($zipcode) {
        return Pp4::where('postcode', substr($zipcode, 0, 4))->value('woonplaats');
    }
}
