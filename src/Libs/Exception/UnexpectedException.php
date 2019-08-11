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
 * 未知错误异常
 * Class UnexpectedException
 * @package Core\Http\Controllers\Api\Exception
 */
class UnexpectedException extends ApiException{

    public function __construct($message = "unexpected error", $data = []){
        parent::__construct($message, Code::UNEXPECTED_ERROR,$data);
    }
}