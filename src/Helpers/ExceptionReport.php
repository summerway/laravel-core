<?php
/**
 * Created by PhpStorm.
 * User: MapleSnow
 * Date: 2019/08/08
 * Time: 10:05
 */

namespace MapleSnow\LaravelCore\Helpers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use MapleSnow\LaravelCore\Libs\Exception\ApiException;
use Illuminate\Validation\ValidationException;
use MapleSnow\LaravelCore\Libs\Result\Code;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Exception;

class ExceptionReport extends  ExceptionHandler{

    /**
     * @var array
     */
    protected $dontReport = [
        MethodNotAllowedHttpException::class,
        NotFoundHttpException::class
    ];
    
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function report(Exception $e) {
        $request = request();
        if ($e instanceof MethodNotAllowedHttpException) {
            $message = "Method ".$request->method()." not allowed";
            Log::error($message);
        }

        if($e instanceof NotFoundHttpException){
            $message = "[".$request->url()."] not found";
            Log::error($message);
        }

        parent::report($e);
    }

    public function render($request, Exception $e){
        $message = $e->getMessage();
        $code = Code::BAD_REQUEST;
        $data = [];

        // 表单验证错误format
        if ($e instanceof ValidationException) {
            $errors = $e->errors();
            if (count($errors)) {
                $content = array_column($errors, 0);
                $message = implode(';', $content);
            }else{
                $message = $e->getMessage();
            }
        }

        if ($e instanceof AuthenticationException
            || $e instanceof UnauthorizedHttpException) {
            $message = "Unauthenticated";
            $code = Code::UNAUTHORIZED;
        }

        if ($e instanceof AuthorizationException) {
            $message = "Forbidden";
            $code = Code::FORBIDDEN;
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            $message = "Method ".$request->method()." not allowed";
            $code = Code::BAD_REQUEST;
        }

        if($e instanceof NotFoundHttpException){
            $message = "Request not found";
            $code = Code::BAD_REQUEST;
        }

        if ($e instanceof ApiException) {
            $message = $e->getMessage();
            $code = $e->getCode();
            $data = $e->getData();
        }

        return $this->response($message,$code,$data);
    }

    /**
     * 异常统一返回（外部可继承重写）
     * @param $message
     * @param $code
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($message, $code,$data){
        return ajaxError($message,$code,$data);
    }
}