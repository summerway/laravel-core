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
    protected $signature = 'make:flow {object} {comment}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '一条命令创建基础文件 php artisan make:flow {对象} {备注}';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

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

        $message = [];
        $date = date('Y/m/d');
        $time = date("g:i A");

        // controller
        !file_exists($this::PATH_API_CONTROLLER) && mkdir($this::PATH_API_CONTROLLER);
        $controllerFile = "{$objectU}Controller.php";
        if(!File::exists($this::PATH_API_CONTROLLER . $controllerFile)){
            $controllerStub = file_get_contents($this::PATH_STUB.'controller.stub');
            $controllerContent = str_replace(['[$objectU]','[$object]','[$comment]','[$date]','[$time]'],[$objectU,$object,$comment,$date,$time],$controllerStub);

            File::put($this::PATH_API_CONTROLLER . $controllerFile,$controllerContent);
            $message[] = "生成{$comment}Controller：{$controllerFile}";
        }else{
            $message[] = "{$controllerFile}已存在";
        }

        // migration
        $migrationFile = date("Y_m_d_his")."_create_{$objects}_table.php";
        if($this->checkMigrationUnique($objects)){
            $migrationStub = file_get_contents($this::PATH_STUB.'migration.stub');
            $migrationContent = str_replace(['[$objectsU]','[$objects]','[$comment]','[$date]','[$time]'],[$objectsU,$objects,$comment,$date,$time],$migrationStub);
            File::put($this::PATH_MIGRATION . $migrationFile,$migrationContent);
            $message[] = "生成{$comment}Migration：{$migrationFile}";
        }else{
            $message[] = "create_{$objects}_table.php已存在";
        }

        // model
        !file_exists($this::PATH_MODEL) && mkdir($this::PATH_MODEL);
        $modelFile = "{$objectU}.php";
        if(!File::exists($this::PATH_MODEL . $modelFile)){
            $modelStub = file_get_contents($this::PATH_STUB.'model.stub');
            $modelContent = str_replace(['[$objectU]','[$object]','[$date]','[$time]'],[$objectU,$object,$date,$time],$modelStub);
            File::put($this::PATH_MODEL . $modelFile,$modelContent);
            $message[] = "生成{$comment}Model：{$modelFile}";
        }else{
            $message[] = "{$modelFile}已存在";
        }

        // resource
        !file_exists($this::PATH_RESOURCE) && mkdir($this::PATH_RESOURCE);
        $resourceFile = "{$objectU}Resource.php";
        if(!File::exists($this::PATH_RESOURCE . $resourceFile)){
            $resourceStub = file_get_contents($this::PATH_STUB.'resource.stub');
            $resourceContent = str_replace(['[$objectU]','[$object]','[$date]','[$time]'],[$objectU,$object,$date,$time],$resourceStub);
            File::put($this::PATH_RESOURCE . $resourceFile,$resourceContent);
            $message[] = "生成{$comment}Resource：{$resourceFile}";
        }else{
            $message[] = "{$resourceFile}已存在";
        }

        // service
        !file_exists($this::PATH_SERVICE) && mkdir($this::PATH_SERVICE);
        $serviceFile = "{$objectU}Service.php";
        if(!File::exists($this::PATH_SERVICE . $serviceFile)){
            $serviceStub = file_get_contents($this::PATH_STUB.'service.stub');
            $serviceContent = str_replace(['[$objectU]','[$object]','[$comment]','[$date]','[$time]'],[$objectU,$object,$comment,$date,$time],$serviceStub);
            File::put($this::PATH_SERVICE . $serviceFile,$serviceContent);
            $message[] = "生成{$comment}Service：{$serviceFile}";
        }else{
            $message[] = "{$serviceFile}已存在";
        }

        // request
        !file_exists($this::PATH_REQUEST) && mkdir($this::PATH_REQUEST);
        $requestDir = $this::PATH_REQUEST.$objectU."/";
        $storeRequestFile = "StoreRequest.php";
        if(!File::exists($requestDir . $storeRequestFile)){
            @File::makeDirectory($requestDir);
            $requestStub = file_get_contents($this::PATH_STUB."storeRequest.stub");
            $requestContent = str_replace(['[$objectU]','[$object]','[$objects]','[$comment]','[$date]','[$time]'],[$objectU,$object,$objects,$comment,$date,$time],$requestStub);
            File::put($requestDir. $storeRequestFile,$requestContent);
            $message[] = "生成{$comment}Service：{$storeRequestFile}";
        }else{
            $message[] = "{$storeRequestFile}已存在";
        }

        $updateRequestFile = "UpdateRequest.php";
        if(!File::exists($requestDir . $updateRequestFile)){
            $requestStub = file_get_contents($this::PATH_STUB."updateRequest.stub");
            $requestContent = str_replace(['[$objectU]','[$object]','[$objects]','[$comment]','[$date]','[$time]'],[$objectU,$object,$objects,$comment,$date,$time],$requestStub);
            File::put($requestDir. $updateRequestFile,$requestContent);
            $message[] = "生成{$comment}Service：{$updateRequestFile}";
        }else{
            $message[] = "{$updateRequestFile}已存在";
        }

        // routes
        $originContent = file_get_contents($this::PATH_API_ROUTES);
        if(false === strpos($originContent,"'prefix' => '{$object}'")){
            $routeStub = file_get_contents($this::PATH_STUB.'route.stub');
            $routeContent = str_replace(['[$objectU]','[$object]','[$comment]'],[$objectU,$object,$comment],$routeStub);
            File::append($this::PATH_API_ROUTES,"\n".$routeContent);
            $message[] = "生成{$comment}路由表";
        }else{
            $message[] = "{$comment}路由表已存在";
        }

        // lang
        $insertContent = "  {$object}:\n    table_name: '{$comment}' # by make:flow";

        $content = file_get_contents($this::PATH_LANG);
        $initFlag=  "# custom attribute\nattribute:\n";
        if(false === strpos($content,$initFlag)){
            // init
            File::append($this::PATH_LANG,"\n".$initFlag.$insertContent);
            $message[] = "生成{$comment}翻译";
        }else{
            if(false === strpos($content,$insertContent)){
                insertAfterTarget($this::PATH_LANG,$insertContent,"\nattribute");
                $message[] = "生成{$comment}翻译";
            }else{
                $message[] = "{$comment}语言包初始化内容已存在";
            }
        }

        $this->info(implode("\n",$message));
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
}
