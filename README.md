## 简介
laravel开发常用核心组件

## 安装

```bash
# 安装依赖
composer require maplesnow/laravel-core
# 发布core资源文件
php artisan vendor:publish --provider="MapleSnow\LaravelCore\Providers\CoreServiceProvider"
# 发布语言包资源文件
php artisan vendor:publish --provider="MapleSnow\Yaml\TranslationServiceProvider"
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

### 文件导出
封装[laravel-excel](https://github.com/Maatwebsite/Laravel-Excel) 导出流程，内置导出样式，使流程更简洁
单sheet示例
继承Export抽象类，实现`query`,`map`,`headings`方法
```php
use MapleSnow\LaravelCore\Helpers\Export;

class PostExport extends Export implements WithTitle {

    public function query()
    {
        return Post::with('creator')->limit(100);
    }

    public function title(): string {
        return 'Post';
    }

    /**
     * @param Post $post
     * @return array
     */
    public function map($post): array
    {
        return [
            $post->id,
            $post->title,
            $post->creator->name,
            $post->created_at
        ];
    }

    public function headings(): array {
        return [
            '#',
            'Title',
            'Author',
            'CreateTime'
        ];
    }
}
```

多sheet示例
```php
class MultiPost implements WithMultipleSheets {

    public function sheets() :array{

        $sheets[] = new PostExport();
        //$sheets[] = new PostExport();
        return $sheets;
    }
}
```

## todo
数据加密
https://learnku.com/articles/8584/php-and-web-end-symmetric-encryption-transmission-jsencryptcryptojs

