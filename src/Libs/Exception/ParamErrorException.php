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
 * 参数错误异常
 * Class ParamErrorException
 * @package Core\Http\Controllers\Api\Exception
 */
class ParamErrorException extends ApiException{

    public function __construct($message = "param error",$data = []){
        parent::__construct($message, Code::PARAM_ERROR,$data);
    }

}