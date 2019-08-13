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


