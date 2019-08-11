<?php
/**
 * Created by PhpStorm.
 * User: maple.xia
 * Date: 02/08/2019
 * Time: 10:14 PM
 */

namespace MapleSnow\LaravelCore\Http\Resources;

use MapleSnow\LaravelCore\Libs\Result\Code;
use MapleSnow\LaravelCore\Libs\Result\Result;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

/**
 * 多行数据格式化
 * Class BaseCollection
 * @package App\Http\Resources
 */
class BaseCollection extends ResourceCollection
{

    public static $wrap = null;
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects;

    /**
     * Create a new resource instance.
     *
     * @param  mixed $resource
     * @param $collects
     */
    public function __construct($resource, $collects) {
        $this->collects = $collects;

        parent::__construct($resource);
    }


    public function withResponse($request, $response) {
        $data = (new Result(Code::SUCCESS, '', $response->getData(true)))->toArray();
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
