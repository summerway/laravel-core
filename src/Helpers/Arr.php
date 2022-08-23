<?php
/**
 * Created by PhpStorm.
 * User: MapleSnow
 * Date: 2019/9/19
 * Time: 4:23 PM
 */

namespace MapleSnow\LaravelCore\Helpers;

use Illuminate\Support\Arr as LArr;

class Arr extends LArr {

    /**
     * 过滤数组
     * @param array $array
     * @param string $keyword
     * @return array
     */
    public static function filter(array $array,string $keyword) : array{
        return array_filter($array,function($var) use ($keyword){
            return !strpos($var,$keyword);
        });
    }

    /**
     * 查找特定数据元素
     * @param array $array
     * @param string $keyword
     * @return array
     */
    public static function search(array $array,string $keyword) : array {
        return array_filter($array,function($var) use ($keyword){
            return strpos($var,$keyword);
        });
    }
}