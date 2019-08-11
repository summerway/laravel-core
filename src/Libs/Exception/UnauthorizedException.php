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
 * 未授权异常
 * Class UnauthorizedException
 * @package Core\Http\Controllers\Api\Exception
 */
class UnauthorizedException extends ApiException{

    public function __construct($message = "unauthorized", $data = []){
        parent::__construct($message, Code::UNEXPECTED_ERROR,$data);
    }
}