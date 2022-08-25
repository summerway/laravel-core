<?php
/**
 * Created by PhpStorm.
 * User: MapleSnow
 * Date: 2022/8/24
 * Time: 16:40
 */

namespace MapleSnow\LaravelCore\Helpers\Upload\Disk;


use MapleSnow\LaravelCore\Helpers\Upload\FileStorage;

use zgldh\QiniuStorage\QiniuStorage;

class QiniuFileStorage implements FileStorage {

    private $storage;

    public function __construct() {
        $this->storage = QiniuStorage::disk("qiniu");
    }

    function upload(string $fileCode, string $content): bool {
        return $this->storage->put($fileCode, $content);
    }

    function getUrl(string $fileCode): string {
        return $this->storage->privateDownloadUrl($fileCode, [
            "domain" => "https",
            "expires" => 3 * ONE_DAY
        ]);

    }

    function delete(string $fileCode): bool {
        return $this->storage->delete(array_wrap($fileCode));
    }
}