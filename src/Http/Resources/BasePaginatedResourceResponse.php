<?php
/**
 * Created by PhpStorm.
 * User: maple.xia
 * Date: 02/08/2019
 * Time: 10:14 PM
 */

namespace MapleSnow\LaravelCore\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;

class BasePaginatedResourceResponse extends PaginatedResourceResponse
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function toResponse($request) {
        return tap(response()->json(
            $this->wrap(
                $this->resource->resolve($request),
                $this->paginationInformation($request)
            ),
            $this->calculateStatus()
        ), function ($response) use ($request) {
            $this->resource->withResponse($request, $response);
        });
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function paginationInformation($request) {
        $paginated = $this->resource->resource->toArray();
        $total = $paginated['total'] ?? 0;
        $data = [
            'pageInfo' => [
                'page'  => intval($request->input('page', 1)),
                'size'  => $this->getPageSize($request),
                'total' => $total,
            ],
        ];
        return $data;
    }

    /**
     * @param $request
     * @return int
     */
    private function getPageSize($request) {
        return (int)($request->get('size', env('DATA_PER_PAGE', 10)));
    }
}
