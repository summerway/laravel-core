<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 11/09/2018
 * Time: 2:18 PM
 */

namespace MapleSnow\LaravelCore\Helpers\Lock;

use Illuminate\Support\Facades\Redis;

/**
 * Redis 锁
 * Class RedisLock
 * @package MapleSnow\LaravelCore\Libs\Lock
 */
class RedisLock extends BaseLock
{
    protected $redis;

    public function __construct() {
        $this->redis = Redis::connection();
    }

    protected function lockImpl($key, $expire = 5)
    {
        $is_lock = $this->redis->setnx($key, time() + $expire);

        // 不能获取锁
        while(!$is_lock){

            // 判断锁是否过期
            $lock_time = $this->redis->get($key);

            // 锁已过期，删除锁，重新获取
            if(time() > $lock_time){
                $this->unLockImpl($key);
            }
            $is_lock = $this->redis->setnx($key, time()+$expire);
        }

        return boolval($is_lock);
    }

    protected function tryLockImpl($key,$expire = 5){
        $res = $this->redis->setnx($key, time() + $expire);
        $this->redis->expire($key,$expire);
        return $res;
    }

    protected function unLockImpl($key) {
        return $this->redis->del([$key]);
    }
}