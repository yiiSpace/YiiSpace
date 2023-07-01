<?php 

namespace common\api ;

/**
 * 参考yii异常处理配置我们自己的异常处理类
 * 
 * ~~~php
 * // config/main.php
 * 'components'=>[
 * ...
 *   'errorHandler'=>'exception/error-handler'
 * ...
 * ]
 * ~~~
 */
class ExceptionController extends \yii\web\Controller 
{
    public function actionErrorHandler()
    {
        // TODO ...
    }
}