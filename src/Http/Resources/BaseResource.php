<?php
/**
 * Created by PhpStorm.
 * User: maple.xia
 * Date: 02/08/2019
 * Time: 10:14 PM
 */

namespace MapleSnow\LaravelCore\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use MapleSnow\LaravelCore\Libs\Result\Result;

class BaseResource extends Resource
{
    public $special = false;

    public static $wrap = null;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\JsonResponse $response
     */
    public function withResponse($request, $response) {
        $data = Result::success($response->getData(true))->toArray();
        $response->setData($data);
    }

    /**
     * 单条数据详情
     * @param $resource
     * @return BaseResource
     */
    public static function show($resource){
        return self::make($resource);
    }

    /**
     * 多行数据格式化
     * @param $resource
     * @return BaseCollection
     */
    public static function format($resource) {
        return new BaseCollection($resource, get_called_class());
    }

    /**
     * 列表转换
     * @param mixed $resource
     * @param bool $isMulti 是否展示多选
     * @return ListCollection
     */
    public static function list($resource, $isMulti = false) {
        return new ListCollection($resource, get_called_class(),$isMulti);
    }
}
