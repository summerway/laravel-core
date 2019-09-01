<?php

namespace MapleSnow\LaravelCore\Rules;

use Illuminate\Contracts\Validation\Rule;
use MapleSnow\LaravelCore\Helpers\DateHelper;

class TimeRange implements Rule
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
        if(!is_array($value) || 2 !== count($value)){
            return false;
        }

        $startTime = current($value);
        $endTime = end($value);

        if(!DateHelper::checkTimestamp($startTime) || !DateHelper::checkTimestamp($endTime)){
            return false;
        }

        if($endTime < $startTime || $endTime < time()){
            return false;
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
        return 'time range is invalid';
    }
}
