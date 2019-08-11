<?php
/**
 * Created by PhpStorm.
 * User: maple.xia
 * Date: 02/08/2019
 * Time: 10:14 PM
 */

namespace MapleSnow\LaravelCore\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;
use MapleSnow\LaravelCore\Libs\Result\Code;
use MapleSnow\LaravelCore\Libs\Result\Result;

/**
 * 列表格式化
 * Class ListCollection
 * @package App\Http\Resources
 */
class ListCollection extends ResourceCollection
{
    public static $wrap = 'tbody';

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects;


    /**
     * 是否展示多选
     * @var bool
     */
    public $isMulti;

    /**
     * Create a new resource instance.
     *
     * @param  mixed $resource
     * @param $collects
     * @param bool $isMulti
     */
    public function __construct($resource, $collects, $isMulti = false) {
        $this->collects = $collects;
        $this->isMulti = $isMulti;

        parent::__construct($resource);
    }


    public function withResponse($request, $response) {
        $data = (new Result(Code::SUCCESS, '', $response->getData(true)))->toArray();
        $data['data']['isMulti'] = $this->isMulti;
        $response->setData($data);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request) {
        return $this->resource instanceof AbstractPaginator
            ? (new BasePaginatedResourceResponse($this))->toResponse($request)
            : parent::toResponse($request);
    }
}
