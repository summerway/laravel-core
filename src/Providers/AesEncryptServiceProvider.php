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
            return new AesEncrypter(config("laravel-core.aes.key"),config("laravel-core.aes.cipher"));
        });
    }
}