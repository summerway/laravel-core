<?php

namespace MapleSnow\LaravelCore\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class BaseModel
 * @package MapleSnow\LaravelCore\Models
 */
class BaseModel extends Eloquent {
    /**
     * 批量添加 (可以添加单条也可添加多条记录)
     * @param $data
     * @param bool $timestamps 操作时间信息
     * @return bool
     */
    public static function massiveInsert($data, $timestamps = true) {
        if (!$data) {
            return false;
        }

        if (!is_array(reset($data))) {
            $data = array($data);
        }

        $ext_fields = [];
        if ($timestamps) {
            $now        = Carbon::now()->toDateTimeString();
            $timestamps = [
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $ext_fields = array_merge($ext_fields, $timestamps);
        }

        foreach ($data as &$item) {
            $item = array_merge($item, $ext_fields);
        }

        return static::insert($data);
    }

    /**
     * 批量添加返回ID (可以添加单条也可添加多条记录)
     * @param $data
     * @param bool $timestamps 操作时间信息
     * @return array | bool
     */
    public static function massiveInsertGetIds($data, $timestamps = true) {
        if (!$data) {
            return false;
        }

        if (!is_array(reset($data))) {
            $data = array($data);
        }

        $ids        = [];
        $ext_fields = [];
        if ($timestamps) {
            $now        = Carbon::now()->toDateTimeString();
            $timestamps = [
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $ext_fields = array_merge($ext_fields, $timestamps);
        }

        foreach ($data as &$item) {
            $item  = array_merge($item, $ext_fields);
            $ids[] = static::insertGetId($item);
        }
        return $ids;
    }
}