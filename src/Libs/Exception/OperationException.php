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
 * 操作错误异常
 * Class OperationException
 * @package Core\Http\Controllers\Api\Exception
 */
class OperationException extends ApiException{

    public function __construct($message = "operating exception",$data = []){
        parent::__construct($message, Code::OPERATING_EXCEPTION,$data);
    }
}