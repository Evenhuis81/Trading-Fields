<?php

namespace App\Rules;

use App\Pp4;
use Illuminate\Contracts\Validation\Rule;

class Zipcode implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $string = substr($value, 4, 6);
        if (!preg_match("/^[a-zA-Z]+$/", $string)) {
            return false;
        }
        $postal = substr($value, 0, 4);
        if (!preg_match("/^[0-9]+$/", $postal)) {
            return false;
        }
        return Pp4::where('postcode', $postal)->exists();
        // if (!is_int($postint)) {
        //     return false;
        // }
        // dd($postal);
        // return false;
        // return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This is not a valid :attribute.';
    }
}
