<?php

namespace MapleSnow\LaravelCore\Console;

use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class makeFlowCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:flow {object : 对象} {comment : 备注}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '一条命令创建基础文件 php artisan make:flow {对象} {备注}';

    const
        PATH_STUB = __DIR__.'/stubs/',
        PATH_API_CONTROLLER = __DIR__.'/../../../../../app/Http/Controllers/Api/',
        PATH_MODEL = __DIR__.'/../../../../../app/Models/',
        PATH_MIGRATION = __DIR__.'/../../../../../database/migrations/',
        PATH_SERVICE = __DIR__.'/../../../../../app/Services/',
        PATH_RESOURCE = __DIR__.'/../../../../../app/Http/Resources/',
        PATH_REQUEST = __DIR__.'/../../../../../app/Http/Requests/',
        PATH_API_ROUTES = __DIR__.'/../../../../../routes/api.php',
        PATH_LANG = __DIR__.'/../../../../../resources/lang/zh-CN/lang.yml'
    ;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $argument = $this->argument("object");
        if(empty($argument)){
            $this->error("请填写需创建的对象");
        }

        $comment = $this->argument("comment");
        if(empty($comment)){
            $this->error("请填写备注");
        }

        $object = Str::camel($argument);
        $objects = str_plural($object);
        $objectU = Str::ucfirst($object);
        $objectsU = str_plural($objectU);

        $date = date('Y/m/d');
        $time = date("g:i A");

        $this->generateRequest($objectU, $object, $objects, $comment, $date, $time);
        $this->generateResource($objectU, $object, $date, $time, $comment);
        $this->generateModel($objectU, $object, $date, $time, $comment);
        $this->generateController($objectU, $object, $comment, $date, $time);
        $this->generateService($objectU, $object, $comment, $date, $time);
        $this->generateMigration($objects, $objectsU, $comment, $date, $time);
        $this->generateRouter($object, $objectU, $comment);
        $this->generateLang($object, $comment);
    }

    /**
     * @param $objectU
     * @param $object
     * @param $comment
     * @param $date
     * @param $time
     * @return bool
     */
    protected function generateController($objectU, $object, $comment, $date, $time) {
        if(!$this->checkDir($this::PATH_API_CONTROLLER)){
            $this->error("生成{$comment}Controller失败");
            return false;
        }

        $controllerFile = "{$objectU}Controller.php";
        if (!File::exists($this::PATH_API_CONTROLLER . $controllerFile)) {
            $controllerStub = file_get_contents($this::PATH_STUB . 'controller.stub');
            $controllerContent = str_replace(['[$objectU]', '[$object]', '[$comment]', '[$date]', '[$time]'], [$objectU, $object, $comment, $date, $time], $controllerStub);

            File::put($this::PATH_API_CONTROLLER . $controllerFile, $controllerContent);
            $this->info("生成{$comment}Controller => {$controllerFile}");
        } else {
            $this->warn("{$comment}Controller【{$controllerFile}】已存在");
        }
        return true;
    }

    /**
     * @param $objectU
     * @param $object
     * @param $date
     * @param $time
     * @param $comment
     * @return bool
     */
    protected function generateModel($objectU, $object, $date, $time, $comment) {
        if(!$this->checkDir($this::PATH_MODEL)){
            $this->error("生成{$comment}Model");
            return false;
        }
        $modelFile = "{$objectU}.php";
        if (!File::exists($this::PATH_MODEL . $modelFile)) {
            $modelStub = file_get_contents($this::PATH_STUB . 'model.stub');
            $modelContent = str_replace(['[$objectU]', '[$object]', '[$date]', '[$time]'], [$objectU, $object, $date, $time], $modelStub);
            File::put($this::PATH_MODEL . $modelFile, $modelContent);
            $this->info("生成{$comment}Model => {$modelFile}");
        } else {
            $this->warn("{$comment}Model【{$modelFile}】已存在");
        }
        return true;
    }

    /**
     * @param $objectU
     * @param $object
     * @param $comment
     * @param $date
     * @param $time
     * @return bool
     */
    protected function generateService($objectU, $object, $comment, $date, $time) {
        if(!$this->checkDir($this::PATH_SERVICE)){
            $this->error("生成{$comment}Service");
            return false;
        }
        $serviceFile = "{$objectU}Service.php";
        if (!File::exists($this::PATH_SERVICE . $serviceFile)) {
            $serviceStub = file_get_contents($this::PATH_STUB . 'service.stub');
            $serviceContent = str_replace(['[$objectU]', '[$object]', '[$comment]', '[$date]', '[$time]'], [$objectU, $object, $comment, $date, $time], $serviceStub);
            File::put($this::PATH_SERVICE . $serviceFile, $serviceContent);
            $this->info("生成{$comment}Service => {$serviceFile}");
        } else {
            $this->warn("{$comment}Service【{$serviceFile}】已存在");
        }
        return true;
    }

    /**
     * @param $objects
     * @param $objectsU
     * @param $comment
     * @param $date
     * @param $time
     * @return bool
     */
    protected function generateMigration($objects, $objectsU, $comment, $date, $time) {
        $migrationFile = date("Y_m_d_his") . "_create_{$objects}_table.php";
        if ($this->checkMigrationUnique($objects)) {
            $migrationStub = file_get_contents($this::PATH_STUB . 'migration.stub');
            $migrationContent = str_replace(['[$objectsU]', '[$objects]', '[$comment]', '[$date]', '[$time]'], [$objectsU, $objects, $comment, $date, $time], $migrationStub);
            File::put($this::PATH_MIGRATION . $migrationFile, $migrationContent);
            $this->info("生成{$comment}Migration => {$migrationFile}");
        } else {
            $this->warn("{$comment}Migration【create_{$objects}_table.php】已存在");
        }
        return true;
    }

    /**
     * @param $object
     * @param $objectU
     * @param $comment
     * @return bool
     */
    protected function generateRouter($object, $objectU, $comment) {
        $originContent = file_get_contents($this::PATH_API_ROUTES);
        if (false === strpos($originContent, "'prefix' => '{$object}'")) {
            $routeStub = file_get_contents($this::PATH_STUB . 'route.stub');
            $routeContent = str_replace(['[$objectU]', '[$object]', '[$comment]'], [$objectU, $object, $comment], $routeStub);
            File::append($this::PATH_API_ROUTES, "\n" . $routeContent);
            $this->info("生成{$comment}Api路由表");
        } else {
            $this->warn("{$comment}路由表已存在");
        }
        return true;
    }

    /**
     * @param $objectU
     * @param $object
     * @param $objects
     * @param $comment
     * @param $date
     * @param $time
     * @return bool
     */
    protected function generateRequest($objectU, $object, $objects, $comment, $date, $time) {
        if(!$this->checkDir($this::PATH_REQUEST)){
            $this->error("生成{$comment}Request");
            return false;
        }
        $requestDir = $this::PATH_REQUEST . $objectU . "/";
        $storeRequestFile = "StoreRequest.php";
        if (!File::exists($requestDir . $storeRequestFile)) {
            @File::makeDirectory($requestDir);
            $requestStub = file_get_contents($this::PATH_STUB . "storeRequest.stub");
            $requestContent = str_replace(['[$objectU]', '[$object]', '[$objects]', '[$comment]', '[$date]', '[$time]'], [$objectU, $object, $objects, $comment, $date, $time], $requestStub);
            File::put($requestDir . $storeRequestFile, $requestContent);
            $this->info("生成{$comment}StoreRequest => {$storeRequestFile}");
        } else {
            $this->warn("{$comment}StoreRequest【{$storeRequestFile}】已存在");
        }

        $updateRequestFile = "UpdateRequest.php";
        if (!File::exists($requestDir . $updateRequestFile)) {
            $requestStub = file_get_contents($this::PATH_STUB . "updateRequest.stub");
            $requestContent = str_replace(['[$objectU]', '[$object]', '[$objects]', '[$comment]', '[$date]', '[$time]'], [$objectU, $object, $objects, $comment, $date, $time], $requestStub);
            File::put($requestDir . $updateRequestFile, $requestContent);
            $this->info("生成{$comment}UpdateRequest => {$updateRequestFile}");
        } else {
            $this->warn("{$comment}UpdateRequest【{$updateRequestFile}】已存在");
        }
        return true;
    }

    /**
     * @param $objectU
     * @param $object
     * @param $date
     * @param $time
     * @param $comment
     * @return bool
     */
    protected function generateResource($objectU, $object, $date, $time, $comment) {
        if(!$this->checkDir($this::PATH_RESOURCE)){
            $this->error("生成{$comment}Resource");
            return false;
        }
        $resourceFile = "{$objectU}Resource.php";
        if (!File::exists($this::PATH_RESOURCE . $resourceFile)) {
            $resourceStub = file_get_contents($this::PATH_STUB . 'resource.stub');
            $resourceContent = str_replace(['[$objectU]', '[$object]', '[$date]', '[$time]'], [$objectU, $object, $date, $time], $resourceStub);
            File::put($this::PATH_RESOURCE . $resourceFile, $resourceContent);
            $this->info("生成{$comment}Resource => {$resourceFile}");
        } else {
            $this->warn("{$comment}Resource【{$resourceFile}】已存在");
        }
        return true;
    }

    /**
     * @param $object
     * @param $comment
     * @return bool
     */
    protected function generateLang($object, $comment) {
        $insertContent = "  {$object}:\n    table_name: '{$comment}' # by make:flow";

        $content = file_get_contents($this::PATH_LANG);
        $initFlag=  "# custom attribute\nattribute:";
        if(false === strpos($content,$initFlag)){
            // init
            File::append($this::PATH_LANG,"\n{$initFlag}\n".$insertContent);
            $this->info("生成{$comment}翻译");
        }else{
            if(false === strpos($content,$insertContent)){
                insertAfterTarget($this::PATH_LANG,$insertContent,$initFlag);
                $this->info("生成{$comment}翻译");
            }else{
                $this->warn("{$comment}语言包初始化内容已存在");
            }
        }

        return true;
    }

    /**
     * 迁移文件的唯一性
     * @param $objects
     * @return bool
     */
    private function checkMigrationUnique($objects){
        $migrationFiles = scandir($this::PATH_MIGRATION);

        foreach ($migrationFiles as $filename){
            if(false !== strpos($filename,"create_{$objects}_table.php")){
                return false;
            }
        }

        return true;
    }

    /**
     * 检查初始目录
     * @param $dir
     * @return bool
     */
    private function checkDir($dir){
        if(file_exists($dir)){
            return true;
        }else{
            return mkdir($dir);
        }
    }
}
