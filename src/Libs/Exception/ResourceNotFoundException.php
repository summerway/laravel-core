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
 * 资源异常
 * Class ResourceNotFoundException
 * @package Core\Http\Controllers\Api\Exception
 */
class ResourceNotFoundException extends ApiException{

    public function __construct($message = "resource not found",$data = []){
        parent::__construct($message, Code::RESOURCE_NOT_FOUND, $data);
    }

}