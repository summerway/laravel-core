<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 2019-08-19
 * Time: 17:53
 */

namespace MapleSnow\LaravelCore\Providers;

use Illuminate\Support\ServiceProvider;
use MapleSnow\LaravelCore\Helpers\AesEncrypter;

/**
 * Class CoreServiceProvider
 * @package MapleSnow\LaravelCore\Providers
 */
class AesEncryptServiceProvider extends ServiceProvider{

    public function register() {
        $this->app->singleton('AesEncrypt', function () {
            $key = env("AES_KEY","JUK1BHpXaGacW3CrfEXvw8DzzTdCne87");
            $cipher = env("AES_CIPHER","AES-256-CBC");
            return new AesEncrypter($key,$cipher);
        });
    }
}