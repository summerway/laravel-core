<?php

namespace MapleSnow\LaravelCore\Rules;

use Illuminate\Contracts\Validation\Rule;

class Ids implements Rule
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
        //
        if(is_int($value)){
            return true;
        }

        return is_array($value) && boolval(array_filter($value,function($val) {
            return !is_int($val);
        }));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        // todo
        return 'There id is invalid';
    }
}
