<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 09/11/2017
 * Time: 5:27 PM
 */

namespace MapleSnow\LaravelCore\Helpers\Upload;

use MapleSnow\LaravelCore\Libs\Exception\ParamErrorException;
use MapleSnow\LaravelCore\Libs\Exception\ParamMissException;

/**
 * 上传类
 * Class UploadHelper
 * @package App\Helper\Common
 */
class UploadHelper{

    /**
     * todo 优化
     * @deprecated
     * @param string $key 文件key值
     * @param string $path 文件径路
     * @return mixed
     * @throws ParamMissException
     * @throws ParamErrorException
     */
    public static function storage($key,$path = ""){
        $hasFile = request()->hasFile($key);
        if($hasFile){
            $files = request()->file($key);
        }else{
            throw new ParamMissException();
        }

        $lgc = new UploadLogic();

        if(is_array($files)){
            $paths = [];
            foreach($files as $file){
                $path = $lgc->upload($file,$path);
                array_push($paths,$path);
            }

            return count($paths) == 1 ? current($paths) : $paths;
        }else{
            return $lgc->upload($files,$path);
        }
    }
}