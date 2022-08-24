<?php
/**
 * Created by PhpStorm.
 * User: MapleSnow
 * Date: 2022/8/24
 * Time: 16:45
 */

namespace MapleSnow\LaravelCore\Helpers\Upload;


use MapleSnow\LaravelCore\Helpers\Upload\Disk\QiniuFileStorage;

class FileManager {

    private static $instance;

    private $disk;

    private function __construct(?FileStorage $disk) {
        $this->disk = $disk ? : new QiniuFileStorage();
    }

    public static function getInstance(FileStorage $disk = null): FileManager {
        if(is_null(self::$instance)) {
            self::$instance = new FileManager($disk);
        }

        return self::$instance;
    }

    public function upload(string $fileCode, $content) : FileManager{
        $this->disk->upload($fileCode, $content);
        return $this;
    }

    public function getUrl(string $fileCode): string {
        return $this->disk->getUrl($fileCode);
    }

    public function delete(string $fileCode) : bool {
        return $this->disk->delete($fileCode);
    }
}