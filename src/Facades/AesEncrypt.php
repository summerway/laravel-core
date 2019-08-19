<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 19/04/2018
 * Time: 3:22 PM
 */

namespace MapleSnow\LaravelCore\Facades;

use Illuminate\Support\Facades\Facade;

class AesEncrypt extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'AesEncrypt';
    }
}