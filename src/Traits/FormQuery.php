<?php
/**
 * Created by PhpStorm.
 * User: MapleSnow
 * Date: 2019/3/21
 * Time: 2:37 PM
 */

namespace MapleSnow\LaravelCore\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

trait FormQuery{
    public function getSize(){
        return request()->input('size',10);
    }

    public function getSort() {
        return !empty(request()->input('prop')) ? snake_case(request()->input('prop')) : 'id';
    }

    public function getOrder() {
        return request()->input('order') ? substr(request()->input('order'),0,-6) : ORDER_DESC;
    }

    /**
     * 查询数据
     * @param Builder|Model $query
     * @return array
     */
    public function queryList($query){
        return $query->orderBy($this->getSort(),$this->getOrder())->paginate($this->getSize());
    }
}
