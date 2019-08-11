<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 12/10/2017
 * Time: 2:52 PM
 */

namespace MapleSnow\LaravelCore\Libs\Exception;

use MapleSnow\LaravelCore\Libs\Result\Code;

/**
 * Rpc异常
 * Class RpcExceptionResponse
 * @package Core\Http\Controllers\Api\Exception
 */
class RpcResponseException extends ApiException{

    public function __construct($message = "rpc response exception",$data = []){
        parent::__construct($message, Code::RPC_RESPONSE_EXCEPTION,$data);
    }
}