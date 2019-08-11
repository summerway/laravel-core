<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 12/10/2017
 * Time: 2:52 PM
 */

namespace MapleSnow\LaravelCore\Libs\Exception;

use Exception;

/**
 * Api异常返回
 * @author Administrator
 */
class ApiException extends Exception {

    protected $data;

    /**
     * ApiException constructor.
     * @param mixed $message
     * @param string $code
     * @param array $data
     */
    public function __construct($message,$code,$data = []) {
        $this->data = $data;
        parent::__construct(is_array($message) ? json_encode($message) : $message,$code);
    }

    public function getData() {
        return $this->data;
    }
}