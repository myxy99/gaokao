<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

### Laravel6

#### 对Laravel6进行了小修改（也不算是修改,就算是把常用的东西整合上去）

#### 1、返回接口统一
    文件位置：
        App\Providers\ResponseServiceProvider;
    使用：
        response()->success(200, $msg, $data, $status) :
        response()->fail(100, $msg, $data, $status);
#### 2、Monolog\Logger整合
    文件位置：
        App\Utils\Logs
    使用：
        \App\Utils\Logs::logInfo($title, [$msg]);
        \App\Utils\Logs::logWarning($title, [$msg]);
        \App\Utils\Logs::logError($title, [$msg]);
#### 3、JWT整合
    文件位置：
        App\Models\User
    使用：
        jwt整合到了auth，使用与auth一样
#### 4、重写了异常处理
    文件位置：
        App\Exceptions\Handler
    
