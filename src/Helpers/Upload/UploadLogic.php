<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 18/04/2018
 * Time: 11:46 AM
 */

namespace MapleSnow\LaravelCore\Helpers\Upload;

use MapleSnow\LaravelCore\Libs\Exception\ParamErrorException;

/**
 * 上传逻辑类
 * Class UploadLogic
 */
class UploadLogic{

    protected $config;

    function __construct($config = "") {
        $this->config = $config ? : config('FILESYSTEM_DRIVER', 'public');
    }

    /**
     * 上传
     * @param $file
     * @param $path
     * @return string
     * @throws ParamErrorException
     */
    public function upload($file,$path){
        if(!$file->isValid()){
            throw new ParamErrorException("file is invalid");
        }

        switch ($this->config){
            case 'qiniu':
                $fileName = md5($file->getClientOriginalName() . time())
                    . '.' . $file->clientExtension();

                \Storage::disk($this->config)->put($fileName, \File::get($file->path()));

                $path = \Storage::disk($this->config)->getDriver()->downloadUrl($fileName);
                break;
            case 'local':   //本地上传
            default:
                $fileName =  (empty($path) ? '' : $path.'/') .md5($file->getClientOriginalName() . time())
                    . '.' . $file->clientExtension();

                \Storage::disk('public')->put($fileName, \File::get($file->path()));

                $path = request()->getHost().'/storage/' . $fileName;
                break;
        }

        return $path;
    }
}