## 简介
laravel开发常用核心组件

## 安装

```bash
composer require maplesnow/laravel-core
```

## 内容
### Redis锁
```php
$lockKey = "redisKey";
$lock = new RedisLock();
$lock->Lock($lockKey,10);
// logic code
$lock->unLock($lockKey);
```

### 异常处理
`App\Exceptions\Handler` 继承 `ExceptionReport`


## todo
makeflow
model使用query

安全编码
```php
htmlspecialchars(strip_tags($string));
```

数据加密
https://learnku.com/articles/8584/php-and-web-end-symmetric-encryption-transmission-jsencryptcryptojs