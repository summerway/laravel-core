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
        if(!is_array($value)){
            return false;
        }
        foreach($value as $item){
            $isCheck = is_null($item) || (is_numeric($item) && (float)$item > 0);
            if(!$isCheck){
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There id is invalid';
    }
}
