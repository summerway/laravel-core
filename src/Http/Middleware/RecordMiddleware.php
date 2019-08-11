<?php
/**
 * Created by PhpStorm.
 * User: seraph
 * Date: 2017/12/27
 * Time: 11:19
 */

namespace MapleSnow\LaravelCore\Http\Middleware;

use MapleSnow\LaravelCore\Helpers\DateHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\TerminableInterface;
use Illuminate\Support\Facades\Log;

/**
 * API请求记录
 * Class RecordMiddleware
 * @package Core\Http\Middleware
 */
class RecordMiddleware implements TerminableInterface{

    private $startTime;

    public function handle($request, \Closure $next) {
        $this->startTime = DateHelper::getMillisecond();
        $response = $next($request);
        $endTime = DateHelper::getMillisecond();
        $spendTime = $endTime - $this->startTime;
        Log::error("Spend Time: {$spendTime}");
        return $response;
    }

    public function terminate(Request $request, Response $response) {
        $endTime = DateHelper::getMillisecond();
        $spendTime = $endTime - $this->startTime;
        Log::error("Spend Time: {$spendTime}");
    }

}