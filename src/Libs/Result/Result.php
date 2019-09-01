<?php
/**
 * 接口和内部函数(如service,model等)调用的返回结果:
 * 有三个属性:返回码,信息,返回值
 */

namespace MapleSnow\LaravelCore\Libs\Result;

use Exception;
use Illuminate\Support\Facades\Log;

class Result {

    private $code;

    private $message;

    private $data;

    public function getData() {
        return $this->data;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getCode() {
        return $this->code;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    /**
     * 默认的构造函数,不是很常用,因为三个参数传递起来太麻烦了
     * 通常使用指定错误码的参数
     * DrillingResult constructor.
     * @param $code
     * @param $message
     * @param $data
     */
    public function __construct($code, $message, $data) {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @param $message
     * @return Result
     */
    public static function message($message) {
        return new Result(Code::SUCCESS, $message, []);
    }

    /**
     * @param $message
     * @param $data
     * @return Result
     */
    public static function success($data=[],$message="success") {
        return new Result(Code::SUCCESS, $message, $data);
    }

    /**
     * 请求错误
     * @param Exception $e
     * @param string $message
     * @param array $data
     * @return Result
     */
    public static function exception(Exception $e,$message="bad request",$data = []) {
        Log::error($e->getMessage(),array_merge($data, ['exception' => $e]));
        return new Result(Code::BAD_REQUEST, $message, $data);
    }

    /**
     * 请求错误
     * @param string $message
     * @param array $data
     * @return Result
     */
    public static function error($message="bad request", $data=[]) {
        return new Result(Code::BAD_REQUEST, $message, $data);
    }

    /**
     * 参数错误
     * @param string $message
     * @param array $data
     * @return Result
     */
    public static function paramError($message="param error", $data=[]) {
        return new Result(Code::PARAM_ERROR, $message, $data);
    }

    /**
     * 参数缺失
     * @param string $message
     * @param array $data
     * @return Result
     */
    public static function paramMiss($message="param miss", $data=[]) {
        return new Result(Code::PARAM_MISS, $message, $data);
    }

    /**
     * 操作错误
     * @param string $message
     * @param array $data
     * @return Result
     */
    public static function operatingException($message="operating exception", $data=[]) {
        return new Result(Code::OPERATING_EXCEPTION, $message, $data);
    }

    /**
     * 未登录
     * @param string $message
     * @param array $data
     * @return Result
     */
    public static function unauthorized($message="unauthorized", $data=[]) {
        return new Result(Code::UNAUTHORIZED, $message, $data);
    }

    /**
     * 无权操作
     * @param string $message
     * @param array $data
     * @return Result
     */
    public static function forbidden($message="forbidden", $data=[]) {
        return new Result(Code::FORBIDDEN, $message, $data);
    }

    /**
     * 资源不存在
     * @param string $message
     * @param array $data
     * @return Result
     */
    public static function resourceMiss($message="resource not found", $data=[]) {
        return new Result(Code::RESOURCE_NOT_FOUND, $message, $data);
    }

    /**
     * 不支持该操作
     * @param string $message
     * @param array $data
     * @return Result
     */
    public static function notAcceptable($message="not acceptable", $data=[]) {
        return new Result(Code::NOT_ACCEPTABLE, $message, $data);
    }

    /**
     * 系统错误
     * @param string $message
     * @param array $data
     * @return Result
     */
    public static function unexpectedError($message="unexpected error", $data=[]) {
        return new Result(Code::UNEXPECTED_ERROR, $message, $data);
    }

    /**
     * 远程服务器未响应
     * @param string $message
     * @param array $data
     * @return Result
     */
    public static function rpcNoResponse($message="rpc no response", $data=[]) {
        return new Result(Code::RPC_NO_RESPONSE, $message, $data);
    }

    /**
     * 远程服务接口请求异常
     * @param string $message
     * @param array $data
     * @return Result
     */
    public static function rpcResponseException($message="rpc response exception", $data=[]) {
        return new Result(Code::RPC_RESPONSE_EXCEPTION, $message, $data);
    }

    public function toString() {
        return json_encode([
            "code" => $this->code,
            "message" => $this->message,
            "data" => $this->data
        ]);
    }

    public function toArray() {
        return  [
            'code'    => $this->code,
            'message' => $this->message,
            'data'    => $this->data
        ];
    }

    public function wrong() {
        return $this->code !== Code::SUCCESS;
    }
}