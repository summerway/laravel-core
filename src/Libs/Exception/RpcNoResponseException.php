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
 * Rpc无响应异常
 * Class RpcNoResponseException
 * @package Core\Http\Controllers\Api\Exception
 */
class RpcNoResponseException extends ApiException{

    public function __construct($message = "rpc no response",$data = []){
        parent::__construct($message, Code::RPC_NO_RESPONSE,$data);
    }

}