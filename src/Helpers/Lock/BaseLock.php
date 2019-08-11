<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 11/09/2018
 * Time: 2:18 PM
 */

namespace MapleSnow\LaravelCore\Helpers\Lock;

abstract class BaseLock
{
    /**
     * 悲观锁
     * @param string $key 要锁的key
     * @param int $expire 锁的过期时间
     * @return boolean
     */
    protected abstract function lockImpl($key, $expire=5);

    /**
     * 尝试锁
     * @param $key
     * @param int $expire
     * @return mixed
     */
    protected abstract function tryLockImpl($key,$expire = 5);

    /**
     * 解锁
     * @param string $key  要解锁的key
     * @return boolean
     */
    protected abstract function unLockImpl($key);

    public function lock($key, $expire=5) {
        return $this->lockImpl($this->prepareKey($key), $expire);
    }

    public function tryLock($key,$expire = 5){
        return $this->tryLockImpl($this->prepareKey($key),$expire);
    }

    public function unLock($key){
        return $this->unLockImpl($this->prepareKey($key));
    }

    private function prepareKey($key) {
        return "lock_{$key}";
    }
}