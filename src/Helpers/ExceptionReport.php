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
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Support\Facades\Log;
use MapleSnow\LaravelCore\Libs\Exception\ApiException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Exception;
use MapleSnow\LaravelCore\Libs\Result\Code;

class ExceptionReport{

    /**
     * @var Exception
     */
    public $exception;
    /**
     * @var Request
     */
    public $request;

    /**
     * ExceptionReport constructor.
     * @param Exception $exception
     */
    function __construct(Exception $exception)
    {
        $this->request = request();
        $this->exception = $exception;
    }

    /**
     * @var array
     */
    protected static $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        ValidationException::class
    ];

    /**
     * @return bool
     */
    public function shouldntReport() {
        return is_null(Arr::first($this::$dontReport, function ($type){
            return $this->exception instanceof $type;
        }));
    }

    /**
     * 输出日志
     */
    public function reportLog(){
        $message = $this->exception->getMessage() ." ". $this->exception->getFile() . "(" . $this->exception->getLine() .")";
        $this->shouldntReport() && Log::error($message);
    }

    /**
     * 未知错误
     * @return \Illuminate\Http\JsonResponse
     */
    public function unexpectedException(){
        return $this->render($this->exception);
    }

    function render($msg = ""){
        $this->reportLog();

        $message = $msg ?: $this->exception->getMessage();
        $code = Code::BAD_REQUEST;
        $data = [];

        // 表单验证错误format
        if ($this->exception instanceof ValidationException) {
            $errors = $this->exception->errors();
            if (count($errors)) {
                $content = array_column($errors, 0);
                $message = implode(';', $content);
            }else{
                $message = $this->exception->getMessage();
            }
        }

        if ($this->exception instanceof AuthenticationException
            || $this->exception instanceof UnauthorizedHttpException) {
            $message = "Unauthenticated";
            $code = Code::UNAUTHORIZED;
        }

        if ($this->exception instanceof AuthorizationException) {
            $message = "Forbidden";
            $code = Code::FORBIDDEN;
        }

        if ($this->exception instanceof ApiException) {
            $message = $this->exception->getMessage();
            $code = $this->exception->getCode();
            $data = $this->exception->getData();
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