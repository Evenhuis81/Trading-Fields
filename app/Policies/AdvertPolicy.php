<?php

namespace App\Policies;

use App\Advert;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvertPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the advert.
     *
     * @param  \App\User  $user
     * @param  \App\Advert  $advert
     * @return mixed
     */
    public function view(User $user, Advert $advert)
    {
        //
    }

    /**
     * Determine whether the user can update the advert.
     *
     * @param  \App\User  $user
     * @param  \App\Advert  $advert
     * @return mixed
     */
    public function update(User $user, Advert $advert)
    {
        return $advert->owner_id == $user->id;
    }
}
