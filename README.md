## 简介
laravel开发常用核心组件

## 安装

```bash
# 安装依赖
composer require maplesnow/laravel-core
# 发布资源文件
php artisan vendor:publish --provider="MapleSnow\LaravelCore\Providers\CoreServiceProvider"
```

## 内容
### artisan创建基础文件命令
创建出实体表相关的`controller`,`service`,`model`,`migration`,`resource`,`route`,`request`,`lang`。
一条命令指令完成你的工作流
```bash
make:flow {表名} {备注}
```

### 异常处理
`App\Exceptions\Handler` 继承 `ExceptionReport`


## deprecated
### Redis锁
```php
$lockKey = "redisKey";
$lock = new RedisLock();
$lock->Lock($lockKey,10);
// logic code
$lock->unLock($lockKey);
```

## todo
数据加密
https://learnku.com/articles/8584/php-and-web-end-symmetric-encryption-transmission-jsencryptcryptojs

- file export(pdf/excel)
- rich validation rules
