<?php
/**
 * Created by PhpStorm.
 * User: maple.xia
 * Date: 18/10/2017
 * Time: 3:14 PM
 */

namespace MapleSnow\LaravelCore\Helpers;

use Carbon\Carbon;

/**
 * 日期帮助类
 * Class DateHelper
 * @package App\Lib
 */
class DateHelper {

    /**
     * 获取毫秒级的时间戳
     * @return float
     */
    public static function getMillisecond() {
        list($s1, $s2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }

    /**
     * 字符转毫秒级时间戳
     * @param $date
     * @return int
     */
    public static function micTime($date){
        return strtotime($date) * 1000;
    }

    /**
     * 毫秒级时间戳转日期
     * @param string $format 时间格式
     * @param string $micTimestamp 毫秒级时间戳
     * @return false|string
     */
    public static function micDate($format,$micTimestamp){
        $timestamp = floor($micTimestamp / 1000);
        return date($format,$timestamp);
    }

    /**
     * 获取本月第一天
     * @return false|int
     */
    public static function fstDayThisMonStamp(){
        return mktime(0, 0, 0, date('n'), 1, date('Y'));
    }

    /**
     * 获取本月最后一天时间戳
     * @return false|int
     */
    public static function lstDayThisMonStamp(){
        $fstDay = date('Y-m-01', strtotime(date('Y-m-d')));
        return strtotime("$fstDay +1 month -1 day");
    }

    /**
     * 获取下月第一天
     * @return false|int
     */
    public static function fstDayNextMonStamp(){
        return mktime(0, 0, 0, date('n') + 1, 1, date('Y'));
    }

    /**
     * 获取上月第一天
     * @return false|int
     */
    function fstDayLastMonStamp(){
        return mktime(0, 0, 0, date('n') - 1, 1, date('Y'));
    }

    /**
     * 返回当前时间对像
     * @return Carbon
     */
    public static function now() {
        return Carbon::now("UTC");
    }

    public static function getExpiredTime($expireTime) {
        return Carbon::now()->addSeconds($expireTime)->getTimestamp();
    }

    public static function timestamp($timestamp) {
        return Carbon::createFromTimestampUTC($timestamp)->timezone("UTC");
    }

    /**
     * 校验的时间是否小于当前时间
     * @param $timestamp
     * @return bool
     */
    public static function isPast($timestamp) {
        return static::timestamp($timestamp)->isPast();
    }

    /**
     * 校验的时间是否大于当前时间
     * @param $timestamp
     * @return bool
     */
    public static function isFuture($timestamp) {
        return static::timestamp($timestamp)->isFuture();
    }

    /**
     * 日期格式化
     * @param $time
     * @return string
     */
    public static function formatDate($time) {
        $t = DateHelper::getMillisecond() - $time;
        $f = array(
            '31536000000' => '年',
            '2628000000' => '个月',
            '604800000' => '星期',
            '86400000' => '天',
            '3600000' => '小时',
            '60000' => '分钟',
            '1000' => '秒'
        );
        foreach ($f as $k => $v) {
            if (0 != $c = floor($t / (int)$k)) {
                return $c . $v . '前';
            }
        }
    }

    /**
     * 校验是否是时间戳
     * @param $str
     * @return bool
     */
    public static function checkTimestamp($str){
        return ctype_digit($str) && $str <= 2147483647;
    }

    /**
     * 校验是否是毫秒时间戳
     * @param $str
     * @return bool
     */
    public static function checkMicTimestamp($str){
        return ctype_digit($str) && $str <= 2147483647000;
    }
}