## Laravel 验证

- 配置

~~~php

$app->withFacades();
$app->withEloquent();
$app->configure('database'); // 只此一行 就可以开启 lumen 的验证系统

~~~

- 控制器中的使用
~~~php

public function create(Request $request)
{
    $this->validate(
    $request,
        [
            'name' => 'required|string|unique:secrets,name',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'location_name' => 'required|string'
        ]
    );

~~~

##  YII 中的也可以！

利用yii的 DynamicModel  可以容易地实现这种验证方式
区别点 在rules 规则  如果写个解析功能 可以让laravel和yii的规则互相转化