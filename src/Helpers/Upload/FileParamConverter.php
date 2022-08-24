<?php
/**
 * Created by PhpStorm.
 * User: MapleSnow
 * Date: 2022/8/24
 * Time: 16:52
 */

namespace MapleSnow\LaravelCore\Helpers\Upload;

use Illuminate\Http\UploadedFile;

class FileParamConverter {

    /**
     * 上传的文件转化成标准上传参数
     * @param UploadedFile $file
     * @param string $module
     * @param string $prefix
     * @return array
     */
    public static function uploadedFileToFileInfo(UploadedFile $file,string $module, string $prefix = "") : array{
        $originalName = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $fileCode = $module . DIRECTORY_SEPARATOR . trim($prefix, "/") . "/" . generateToken() . "/" . $originalName;
        $content = file_get_contents($file->getRealPath());
        return [$fileCode, $originalName, $ext, $content];
    }

    /**
     * 上传文件转化成临时文件Key值
     * @param UploadedFile $file
     * @param string $prefix
     */
    public static function uploadedFileToTmpCode(UploadedFile $file, string $prefix = "") {
        $ext = $file->getClientOriginalExtension();
        return trim($prefix, "/") . "/" .generateToken() . "." .$ext;
    }
}