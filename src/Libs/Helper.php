<?php
/**
 * Created by PhpStorm.
 * User: MapleSnow
 * Date: 2019/8/10
 * Time: 10:13 PM
 */


namespace {
    /*************************  Common  ***************************/
    const
        ONE_DAY = 86400,        // 一天的时间戳

        ORDER_ASC = 'asc',
        ORDER_DESC = 'desc'
    ;

    if (!function_exists('securityString')) {
        /**
         * 过滤特殊字符
         * @param $str
         */
        function securityString($str){
            htmlspecialchars(strip_tags($str));
        }
    }

    if (!function_exists('generateNumber')) {
        /**
         * 生成数字
         * @param int $length
         * @return string
         */
        function generateNumber($length = 5) {
            $str = '0123456789';
            $number = '';
            for ($i = 0; $i < $length; $i++) {
                $number .= $str{mt_rand(0,strlen($str)-1)};
            }
            return $number;
        }
    }

    if (!function_exists('generateToken')) {
        /**
         * 生成token
         * @return string
         */
        function generateToken() {
            return md5(uniqid());
        }
    }

    if (!function_exists('generateCode')) {
        /**
         * 生成code
         * @param int $length
         * @return string
         */
        function generateCode($length = 8) {
            $str = 'abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
            $number = '';
            for ($i = 0; $i < $length; $i++) {
                $number .= $str{mt_rand(0,strlen($str)-1)};
            }
            return $number;
        }
    }

    if (!function_exists('generatePassword')) {
        /**
         * 生成密码
         * @param int $length
         * @return string
         */
        function generatePassword($length = 8) {
            $str1 = 'abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
            $pw = "";
            $letter = rand(4, 5);
            for ($i = 0; $i < $letter; $i++) {
                $pw .= $str1{mt_rand(0,strlen($str1)-1)};
            }

            $str2 = '!@#$%^&*.+-?,';
            $symbol = rand(1, 2);
            for ($i = 0; $i < $symbol; $i++) {
                $pw .= $str2{mt_rand(0,strlen($str2)-1)};
            }

            $str3 = '123456789';
            $number = $length - $letter - $symbol;
            for ($i = 0; $i < $number; $i++) {
                $pw .= $str3{mt_rand(0,strlen($str3)-1)};
            }
            return str_shuffle($pw);
        }
    }

    if (! function_exists('formatMobile')) {
        /**
         * 手机号脱敏
         * @param $mobile
         * @return null|string|string[]
         */
        function formatMobile($mobile) {
            if (strlen($mobile) < 8) {
                return substr($mobile, 0, 3) . '****';
            } else {
                $mobile  = str_replace('-', '', $mobile);
                $pattern = "/(\d{0,3})\d{4}(\d{4})/";

                $replacement = "\$1****\$2";
                return preg_replace($pattern, $replacement, $mobile);
            }
        }
    }

    if(!function_exists('isMobile')){

        /**
         * @return bool
         */
        function isMobile() {
            // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
            if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
                return true;

            //此条摘自TPM智能切换模板引擎，适合TPM开发
            if(isset ($_SERVER['HTTP_CLIENT']) &&'PhoneClient'==$_SERVER['HTTP_CLIENT'])
                return true;
            //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
            if (isset ($_SERVER['HTTP_VIA']))
                //找不到为flase,否则为true
                return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
            //判断手机发送的客户端标志,兼容性有待提高
            if (isset ($_SERVER['HTTP_USER_AGENT'])) {
                $clientkeywords = array(
                    'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
                );
                //从HTTP_USER_AGENT中查找手机浏览器的关键字
                if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                    return true;
                }
            }
            //协议法，因为有可能不准确，放到最后判断
            if (isset ($_SERVER['HTTP_ACCEPT'])) {
                // 如果只支持wml并且不支持html那一定是移动设备
                // 如果支持wml和html但是wml在html之前则是移动设备
                if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                    return true;
                }
            }
            return false;
        }
    }

    /*************************  ArrayUtil ***************************/

    if(!function_exists('array2front')){
        /**
         * 数组转前端select
         * @param $arr
         * @param string $keyField
         * @param string $labelField
         * @return array
         */
        function array2front($arr,$keyField = 'value', $labelField = 'label') : array{
            foreach($arr as $$keyField => $$labelField){
                $pack[] = compact($keyField,$labelField);
            }

            return $pack ?? [];
        }
    }

    if(!function_exists('arraySort')){
        /**
         * 二维数组按指定的键值排序
         * @param array $arr 源数组
         * @param string $column 排序字段
         * @param int $order 排序方式
         * @return array|boolean{{
         */
        function arraySort ($arr, $column, $order = SORT_DESC) {
            array_multisort(array_column($arr,$column),$order,$arr);
            return $arr;
        }
    }

    /*************************  Validation  ***************************/
    if (!function_exists('checkName')) {    /**
     */
        /**
         * 校验名称
         * @param $name
         * @return false|int
         */
        function checkName($name)
        {
            $pattern = "/^[\x{4e00}-\x{9fa5}A-Za-z]{2,16}$/u";//字母和中文
            return preg_match($pattern,$name);
        }
    }

    if (!function_exists('checkMail')) {
        /**
         * 校验邮箱
         * @param $mail
         * @return false|int
         */
        function checkMail($mail)
        {
            $pattern = "/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";//定义正则表达式
            return preg_match($pattern,$mail);
        }
    }

    if (!function_exists('checkPhone')) {
        /**
         * 验证大陆手机号
         * @param string $mobile
         * @return bool
         */
        function checkPhone($mobile) {
            return preg_match('/^((13[0-9])|(14[5,7,9])|(15[^4])|(18[0-9])|(19[0-9])|(17[0,1,3,5,6,7,8]))\d{8}$/', $mobile) ? TRUE : FALSE;
        }
    }

    if(!function_exists('checkIdentity')){
        /**
         * 验证身份证号格式
         * @param string $id
         * @return bool
         */
        function checkIdentity($id) {
            $id = strtoupper($id);
            $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/";
            $arr_split = array();
            if (!preg_match($regx, $id)) {
                return FALSE;
            }
            if (15 == strlen($id)) //检查15位
            {
                $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";

                @preg_match($regx, $id, $arr_split);
                //检查生日日期是否正确
                $dtm_birth = "19" . $arr_split[2] . '/' . $arr_split[3] . '/' . $arr_split[4];
                if (!strtotime($dtm_birth)) {
                    return FALSE;
                } else {
                    return TRUE;
                }
            } else      //检查18位
            {
                $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
                @preg_match($regx, $id, $arr_split);
                $dtm_birth = $arr_split[2] . '/' . $arr_split[3] . '/' . $arr_split[4];
                if (!strtotime($dtm_birth)) //检查生日日期是否正确
                {
                    return FALSE;
                } else {
                    //检验18位身份证的校验码是否正确。
                    //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
                    $arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
                    $arr_ch = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
                    $sign = 0;
                    for ($i = 0; $i < 17; $i++) {
                        $b = (int)$id{$i};
                        $w = $arr_int[$i];
                        $sign += $b * $w;
                    }
                    $n = $sign % 11;
                    $val_num = $arr_ch[$n];
                    if ($val_num != substr($id, 17, 1)) {
                        return FALSE;
                    }
                    else {
                        return TRUE;
                    }
                }
            }
        }
    }
}