<?php

use MapleSnow\LaravelCore\Libs\Result\Code;
use MapleSnow\LaravelCore\Libs\Result\Result;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('ajaxSuccess')) {
    function ajaxSuccess($data, $message = '', $code = Code::SUCCESS) {
        return response()->json((new Result($code, $message, $data))->toArray());
    }
}

if (!function_exists('ajaxMessage')) {
    function ajaxMessage($message = 'success', $data = [], $code = Code::SUCCESS) {
        return response()->json((new Result($code, $message, $data))->toArray());
    }
}

if (!function_exists('ajaxError')) {
    function ajaxError($message = 'error', $code = Code::BAD_REQUEST, $data = [], $status_code = Response::HTTP_OK) {
        return response()->json((new Result($code, $message, $data))->toArray(),$status_code);
    }
}

if (!function_exists('ajaxResult')) {
    function ajaxResult(Result $result) {
        return response()->json($result->toArray());
    }
}

if (!function_exists('coreAsset')) {
    function coreAsset($path) {
        return asset("/vendor/laravel-core/{$path}");
    }
}

/*if (!function_exists('ajaxLogin')) {
    function ajaxLogin($token,$message = '登录成功', $data = [], $code = Code::SUCCESS) {
        return response()->json((new Result($code, $message, $data))->toArray())->header('Authorization', 'Bearer ' . $token);
    }
}*/

if (!function_exists('downloadFile')) {
    /**
     * 下载文件方法
     * @param $file
     * @param null $name
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    function downloadFile($file,$name = null,$headers = array()){
        return response()->download($file, $name, $headers);
    }
}

if (!function_exists('showFile')) {
    /**
     * 文件只浏览器展示
     * @param $file
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    function showFile($file){
        return response()->file($file);
    }
}


if (! function_exists('clientIp')) {
    /**
     * 获取用户ip
     * @return string|null
     */
    function clientIp(){
        $res = explode(",",request()->header('x-forwarded-for'));
        if($res){
            $ip = trim(current($res));
        }else{
            $ip = request()->getClientIp();
        }
        return $ip;
    }
}

if(! function_exists('insertAfterTarget')) {
    /**
     * 正则查找文件中关键字，新起一行插入内容
     * @param string $filePath 文件路径
     * @param string $insert 插入内容
     * @param string $target 目标
     */
    function insertAfterTarget($filePath, $insert, $target) {
        $result = null;
        $fileContent = file_get_contents($filePath);
        preg_match("/{$target}/",$fileContent,$matches,PREG_OFFSET_CAPTURE);

        $targetIndex = end($matches)[1] + strlen($target) ?? 0;
        if ($targetIndex) {
            #找到target的后一个换行符
            $chLineIndex = strpos(substr($fileContent, $targetIndex), "\n") + $targetIndex;
            if ($chLineIndex !== false) {
                #插入需要插入的内容
                $result = substr($fileContent, 0, $chLineIndex + 1) . $insert . "\n" . substr($fileContent, $chLineIndex + 1);
                $fp = fopen($filePath, "w+");
                fwrite($fp, $result);
                fclose($fp);
            }
        }
    }
}