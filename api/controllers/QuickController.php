<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/6/12
 * Time: 6:34
 */

namespace api\controllers;


use year\db\DynamicActiveRecord;
use yii\rest\ActiveController;
use yii\web\Response;

const  REST_TABLE_NAME = '__rest_table_name__';

/*
if(isset(\Yii::$app->params[REST_TABLE_NAME])){
    $tableName = \Yii::$app->params[REST_TABLE_NAME] ;
    DynamicActiveRecord::setTableName($tableName) ;
}else{
    DynamicActiveRecord::setTableName('admin_menu') ;
}
*/
/*
$cache = \Yii::$app->getCache() ;
if($tableName = $cache->get(REST_TABLE_NAME)){
    DynamicActiveRecord::setTableName($tableName) ;
    print(1) ;
}else{
    DynamicActiveRecord::setTableName($tableName) ;
    print_r(2) ;
}
*/

/*
print_r($_REQUEST) ;
if(isset($_REQUEST[REST_TABLE_NAME])){
    $tableName = $_REQUEST[REST_TABLE_NAME] ;
    DynamicActiveRecord::setTableName($tableName) ;

}else{
    DynamicActiveRecord::setTableName('admin_menu') ;
}
*/


class QuickController extends ActiveController
{

    public function beforeAction($action)
    {

        if (isset($_REQUEST[REST_TABLE_NAME])) {
            $tableName = $_REQUEST[REST_TABLE_NAME];
            DynamicActiveRecord::setTableName($tableName);

        } else {
            DynamicActiveRecord::setTableName('admin_menu');
        }

        return parent::beforeAction($action);
    }

    public $modelClass = 'year\db\DynamicActiveRecord';


    /**
     * http://127.0.0.1:10077/my-github/YiiSpace/api/web/quick/test?table_name=admin_role
     *
     * ----------------------------------------------------------------------
     *                         ## url 重写
     * 'urlManager' => [
     * 'enablePrettyUrl' => true,
     * // 'enableStrictParsing' => true,
     * 'showScriptName' => false,
     * 'enablePrettyUrl' => true,
     * 'showScriptName' => false,
     * 'enableStrictParsing' => true,
     * 'rules' => [
     *      'api_x/<tableName:\w+>' => 'quick/test',
     *      'api_x/<tableName:\w+>/<id:\d*>' => 'quick/test',
     * ------------------------------------------------------------------------
     *
     * @return int|mixed|\yii\console\Response
     */
    public function actionTest($tableName = '',$id='')
    {
        $request = \Yii::$app->request;

        $tableName = empty($tableName) ?  $request->get('table_name', 'user')
                                     : $tableName ;

        // \Yii::$app->params[REST_TABLE_NAME] = $tableName ;

        // \Yii::$app->getCache()->set(REST_TABLE_NAME,$tableName) ;
        // 意外通信线路
        $_REQUEST[REST_TABLE_NAME] = $tableName;

        // return $_REQUEST ;

        // 关闭掉外侧的结果改写 ,
        // @note 由于没有第二个参数 这样会关闭掉所有注册的事件  是比较危险的做法  ，可以把第二个参数具象化（不要使用匿名函数就OK了）
        // off 函数内部是利用 ===  比较的：  ($eventHandler === $handler)
        \Yii::$app->getResponse()->off(Response::EVENT_BEFORE_SEND) ;

        $httpMethod = $request->getMethod() ; // GET, POST, HEAD, PUT, PATCH, DELETE.

        $request = [
          'no handler for your request ' ,
        ];
        switch ($httpMethod)
        {
            case 'GET':
                if(!empty($id)){
                    $result =  \Yii::$app->runAction('quick/view',['id'=>$id]) ;
                }else{
                    $result =  \Yii::$app->runAction('quick/index') ;
                }
                break;

            case 'POST':
                $result =  \Yii::$app->runAction('quick/create') ;
                break;

            case 'PATCH':
                $result =  \Yii::$app->runAction('quick/update',['id'=>$id]) ;
                break;

            case 'DELETE':
                $result =  \Yii::$app->runAction('quick/delete',['id'=>$id]) ;
                break;

            default:
                echo "No number between 1 and 3";
        }
          //  return array_keys($result) ;
          return ($result) ;
    }

}