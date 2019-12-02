<?php

namespace App;

use App\Bid;
use App\Advert;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'zipcode', 'phonenr', 'isAdman', 'isGuest',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function pictures() {
    //     return $this->hasMany(Image::class, 'owner_id');
    // }

    public function advert()
    {
        return $this->hasMany(Advert::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function time_active() {
        // dd($this->created_at->diffForHumans());
        // return $this->created_at;
        // $timeago = $this->get_time_ago($this->created_at);
        // $timeago = $this->get_time_ago();
        // dd($timeago);
    }

    public function get_time_ago() {
        $dt = Carbon::now();
        $past = $dt->subMonth();
        echo $dt->diffForHumans($past);
        // $time_difference = time() - $time;

        // if( $time_difference < 1 ) { return 'less than 1 second ago'; }
        // $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
        //             30 * 24 * 60 * 60       =>  'month',
        //             24 * 60 * 60            =>  'day',
        //             60 * 60                 =>  'hour',
        //             60                      =>  'minute',
        //             1                       =>  'second'
        // );

        // foreach( $condition as $secs => $str )
        // {
        //     $d = $time_difference / $secs;

        //     if( $d >= 1 )
        //     {
        //         $t = round( $d );
        //         return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        //     }
        // }
    }
}
