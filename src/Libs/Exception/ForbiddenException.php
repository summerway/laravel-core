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
 * 越权操作异常
 * Class ForbiddenException
 * @package Core\Http\Controllers\Api\Exception
 */
class ForbiddenException extends ApiException
{
    public function __construct($message = "forbidden",$data = []){
        parent::__construct($message, Code::FORBIDDEN,$data);
    }
}