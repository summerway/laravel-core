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

    /**
     * 获取每页条数
     * @return int
     */
    public function getSize(){
        return request()->input('size',10);
    }

    /**
     * 获取排序项
     * @return string
     */
    public function getSort() {
        return !empty(request()->input('prop')) ? snake_case(request()->input('prop')) : 'id';
    }

    /**
     * 获取排序规则
     * @return string (asc,desc)
     */
    public function getOrder() {
        $order = request()->input('order',ORDER_DESC);
        // 兼容vue.js
        if(strlen($order) > 6){
            return substr($order,0,-6);
        }
        return $order;
    }

    /**
     * 查询数据
     * @param Builder|Model $query
     * @return mixed
     */
    public function queryList($query){
        if('id' == $this->getSort()){
            return $query->orderBy($this->getSort(),$this->getOrder())->paginate($this->getSize());
        }else{
            return $query->orderBy($this->getSort(),$this->getOrder())->orderBy('id',ORDER_DESC)->paginate($this->getSize());
        }
    }
}
