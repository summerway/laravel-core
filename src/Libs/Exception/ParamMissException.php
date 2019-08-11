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
 * 参数缺失异常
 * Class ParamMissException
 * @package Core\Http\Controllers\Api\Exception
 */
class ParamMissException extends ApiException {

    public function __construct($message = "param miss",$data = []){
        parent::__construct($message, Code::PARAM_MISS,$data);
    }
}