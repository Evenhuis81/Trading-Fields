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
        'title', 'description', 'condition_id', 'price', 'startbid', 'delivery_id', 'name', 'phonenr', 'zipcode', 'zipletters', 'searchzip', 'owner_id',
    ];

    // protected static function boot()
    // {
    //   parent::boot();

    //   static::created(function ($advert) {
    //     // dd('created advert');
    //   });
    // }

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

    public function dis($points, $zipcode) {
      $point = $points->firstwhere('postcode', $zipcode);
      return intval(round($point->distance));
    }

    public function distance($userzip, $destinationzip)
    {
        
        $unit = "K";
        $lat1 = Pp4::where('postcode', substr($userzip, 0, 4))->value('latitude');
        $lon1 = Pp4::where('postcode', substr($userzip, 0, 4))->value('longitude');
        $lat2 = Pp4::where('postcode', substr($destinationzip, 0, 4))->value('latitude');
        $lon2 = Pp4::where('postcode', substr($destinationzip, 0, 4))->value('longitude');
        $distance = $this->distanceinput($lat1, $lon1, $lat2, $lon2, $unit);
        return intval(round($distance));
    }

    private function distanceinput($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
          return 0;
        }
        else {
          $theta = $lon1 - $lon2;
          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $miles = $dist * 60 * 1.1515;
          $unit = strtoupper($unit);
      
          if ($unit == "K") {
            return ($miles * 1.609344);
          } else if ($unit == "N") {
            return ($miles * 0.8684);
          } else {
            return $miles;
          }
        }
      }
}
