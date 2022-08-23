<?php
/**
 * Created by PhpStorm.
 * User: maple.xia
 * Date: 01/08/2019
 * Time: 3:14 PM
 */

namespace MapleSnow\LaravelCore\Http\Middleware;

use Closure;

/**
 * 白名单
 * Class whiteList
 * @package App\Http\Middleware
 */
class WhiteList
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('laravel-core.enable_whiteList',true) && !in_array(clientIp(),config('laravel-core.whiteList',[]))){
            abort(403,'你的IP'.$request->getClientIp() .'不被允许访问，如有误会，请联系管理员');
        }

        return $next($request);
    }
}
