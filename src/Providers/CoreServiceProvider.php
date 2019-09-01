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
use MapleSnow\LaravelCore\Console\makeFlowCommand;
use Exception;

/**
 * Class CoreServiceProvider
 * @package MapleSnow\LaravelCore\Providers
 */
class CoreServiceProvider extends ServiceProvider{

    public function register()
    {
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/laravel-core.php'), 'larvel-core');
        $this->loadViewsFrom(realpath(__DIR__.'/../../resources/views'), 'errors');
    }

    /**
     * @throws Exception
     */
    public function boot()
    {
        $this->check();

        if ($this->app->runningInConsole()) {
            $this->publishes([realpath(__DIR__.'/../../config/laravel-core.php') => config_path('larvel-core.php')]);
            $this->publishes([realpath(__DIR__.'/../../resources/assets') => public_path('vendor/laravel-core')], 'laravel-core-assets');
            $this->publishes([realpath(__DIR__.'/../../resources/views') => resource_path('views')], 'laravel-core-views');
            $this->commands([
                makeFlowCommand::class,
            ]);
        }
    }

    /**
     * @throws Exception
     */
    protected function check() {
        if(!$this->app instanceof LaravelApplication){
            throw new Exception("laravel application is off");
        }
    }
}