@see https://www.cnblogs.com/echojson/articles/10773756.html

速率限制，该操作完全也是出于安全考虑，我们需要限制同一接口某时间段过多的请求。

速率限制默认不启用，用启用速率限制，yii\web\User::identityClass 应该实现yii\filters\RateLimitInterface，也就是说我们的common\models\User.php需要实现yii\filters\RateLimitInterface接口的三个方法，具体代码可参考：

~~~php

use yii\filters\RateLimitInterface;
use yii\web\IdentityInterface;


class User extends ActiveRecord implements IdentityInterface, RateLimitInterface
{
    // other code ...... 


    // 返回某一时间允许请求的最大数量，比如设置10秒内最多5次请求（小数量方便我们模拟测试）
    public  function getRateLimit($request, $action){  
         return [5, 10];  
    }
     
    // 回剩余的允许的请求和相应的UNIX时间戳数 当最后一次速率限制检查时
    public  function loadAllowance($request, $action){  
         return [$this->allowance, $this->allowance_updated_at];  
    }  
     
    // 保存允许剩余的请求数和当前的UNIX时间戳
    public  function saveAllowance($request, $action, $allowance, $timestamp){ 
        $this->allowance = $allowance;  
        $this->allowance_updated_at = $timestamp;  
        $this->save();  
    }  
}

~~~


需要注意的是，你仍然需要在数据表User中新增加两个字段

    allowance：剩余的允许的请求数量
    allowance_updated_at：相应的UNIX时间戳数

在我们启用了速率限制后，Yii 会自动使用 yii\filters\RateLimiter 为 yii\rest\Controller 配置一个行为过滤器来执行速率限制检查。

现在我们通过postman请求v1/users再看看结果，会发现在10秒内调用超过5次API接口，我们会得到状态为429太多请求的异常信息。

~~~js
{
  "name": "Too Many Requests",
  "message": "Rate limit exceeded.",
  "code": 0,
  "status": 429,
  "type": "yii\\web\\TooManyRequestsHttpException"
}
~~~


## 思考🤔

其实对于这种高频访问的东西 不一定非要走db  用redis等应该也可以实现
