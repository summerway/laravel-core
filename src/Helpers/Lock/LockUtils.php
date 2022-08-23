<?php
/**
 * Created by PhpStorm.
 * User: MapleSnow
 * Date: 2020/2/24
 * Time: 10:31 AM
 */

namespace MapleSnow\LaravelCore\Helpers\Lock;

use Illuminate\Support\Facades\Cache;

class LockUtils {

    const PREFIX = 'lock:';

    private static function getKey($key) {
        return static::PREFIX.$key;
    }

    public static function getPessimisticLock($key) {
        do{
            $acquired = static::getLock($key);
        }while($acquired);
    }

    public static function getLock(string $key,int $seconds = 5,$callback = null) {
        return Cache::lock(static::getKey($key),$seconds)->get($callback);
    }
}