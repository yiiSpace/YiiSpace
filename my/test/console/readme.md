可以只建立一个commands 目录  通过 类似giiant方式做到
~~~
    
     public function bootstrap($app)
        {
            if ($app->hasModule('gii')) {
    
                if (!isset($app->getModule('gii')->generators['giiant-model'])) {
                    $app->getModule('gii')->generators['giiant-model'] = 'schmunk42\giiant\model\Generator';
                }
                if (!isset($app->getModule('gii')->generators['giiant-crud'])) {
                    $app->getModule('gii')->generators['giiant-crud'] = 'schmunk42\giiant\crud\Generator';
                }
                if ($app instanceof \yii\console\Application) {
                    $app->controllerMap['giiant-batch'] = 'schmunk42\giiant\commands\BatchController';
                }
            }
        }
    
~~~
上例中 是通过“扩充”app 的controllerMap的方式做到

