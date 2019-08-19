<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 2019/8/18
 * Time: 3:44 PM
 */

namespace MapleSnow\LaravelCore\Http\Middleware;

use Closure;
use MapleSnow\LaravelCore\Facades\AesEncrypt;

/**
 * 解密
 * Class DecryptRequest
 * @package App\Http\Middleware
 */
class DecryptRequest
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
        $cipherData = $request->get("cipherData","");
        if(!empty($cipherData)){
            $data = json_decode(AesEncrypt::decrypt($cipherData),true);
            $request->request->add($data);
        }

        unset($request['cipherData']);

        return $next($request);
    }
}
