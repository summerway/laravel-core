<?php
/**
 * Created by PhpStorm.
 * User: Maple.xia
 * Date: 24/01/2018
 * Time: 11:14 AM
 */

namespace MapleSnow\LaravelCore\Services;

use Closure;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * 数据库服务
 * Class DatabaseService
 * @package Core\Common\Database
 */
class DatabaseService{

    /**
     * 获取数据默认连接
     * @return null
     */
    public static function getDefaultConnect(){
        return config("database.default","mysql");
    }

    /**
     * 跨库事务
     * @param Closure $callback 闭包
     * @param array $databases 操作的数据库
     * @return bool|mixed
     * @throws Exception
     */
    public static function transactions(Closure $callback,$databases = []){
        empty($databases) && $databases = [self::getDefaultConnect()];

        foreach($databases as $db){
            if($db == self::getDefaultConnect()){
                DB::connection()->beginTransaction();
            }else{
                DB::connection($db)->beginTransaction();
            }

        }
        // We'll simply execute the given callback within a try / catch block
        // and if we catch any exception we can rollback the transaction
        // so that none of the changes are persisted to the database.
        try {
            $result = $callback();

            foreach($databases as $db){
                if($db == self::getDefaultConnect()){
                    DB::connection()->commit();
                }else{
                    DB::connection($db)->commit();
                }
            }
        }
        // If we catch an exception, we will roll back so nothing gets messed
        // up in the database. Then we'll re-throw the exception so it can
        // be handled how the developer sees fit for their applications.
        catch (Exception $e) {
            foreach($databases as $db){
                if($db == self::getDefaultConnect()){
                    DB::connection()->rollBack();
                }else{
                    DB::connection($db)->rollBack();
                }

            }

            throw $e;
        }

        return $result;
    }
}