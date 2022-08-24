<?php
/**
 * Created by PhpStorm.
 * User: MapleSnow
 * Date: 2022/8/24
 * Time: 16:36
 */

namespace MapleSnow\LaravelCore\Helpers\Upload;


interface FileStorage {

    function upload(string $fileCode, string $content) : bool;

    function delete(string $fileCode) : bool;

    function getUrl(string $fileCode) : string;
}