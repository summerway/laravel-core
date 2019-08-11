<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 2019-08-04
 * Time: 17:53
 */

namespace MapleSnow\LaravelCore\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Exception;

/**
 * todo
 * Class CoreServiceProvider
 * @package MapleSnow\LaravelCore\Providers
 */
class CoreServiceProvider extends ServiceProvider{

    public function register()
    {

    }

    /**
     * @throws Exception
     */
    public function boot()
    {
        $this->check();
        //$this->publishConfig();
    }

    /**
     * @throws Exception
     */
    protected function check() {
        if(!$this->app instanceof LaravelApplication){
            throw new Exception("laravel application is off");
        }
    }

    protected function publishConfig() {

    }
}