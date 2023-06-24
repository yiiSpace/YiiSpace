<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/6/12
 * Time: 6:34
 */

namespace my\devtools\backend\controllers;

// TODO 这里检查运行环境 仅在开发或者测试环境下可用 不然exit 掉

use Toolkit\Stdlib\Arr\ArrayHelper;
use year\db\DynamicActiveRecord;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\web\HttpException;
use yii\web\Response;

const REST_TABLE_NAME = '__rest_table_name__';

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

/**
 * List of allowed domains.
 * Note: Restriction works only for AJAX (using CORS, is not secure).
 *
 * @return array List of domains, that can access to this API
 */
    public static function allowedDomains()
    {
        return [
            // '*',                        // star allows all domains
            // 'http://test1.example.com',
            // 'http://test2.example.com',
            'http://localhost:5173'
        ];
    }

    public function behaviors()
    {
        // return parent::behaviors();
        $behaviors = [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                    //   'text/html' => Response::FORMAT_HTML, // 这顺序竟然也有影响😂
                ],
            ],
            // 机灵鬼可以用nginx做代理 😄 相当于中间人
            'corsFilter' => [
                // ⚠️ 不同的js http客户端可能有不同的表现 ；fetch可用 axios不一定成功
                // 有个 🐛困扰好久的就是  withCredentials: false, // 😂 这个鬼bug
                // 设置为true 就各种问题了

                'class' => Cors::class,
                'cors' => [
                    // 这对配置也👌
                    //  Origin 和 'Access-Control-Allow-Credentials' 是有关联的 前者表示允许那些域访问 后者表示是否允许携带cookie信息
                    'Origin' => static::allowedDomains(), //  跨域的域名数组
                    'Access-Control-Allow-Credentials' => true, //当有origin数组配置时这里为true或者false影响不大了

                    // 👇这两个配置搭配也可以成功 👌
                    // 'Origin' => ['*'],//跨域的域名数组 * 表示允许任意域来访问
                    // 跨域请求中 不允许在请求头中携带凭证 如cookie
                    // 'Access-Control-Allow-Credentials' => false,

                    // 允许客户端的请求方法 跨域中Options 预请求是必须的  ；也有人这个设置用* 这里都列出来为了学习用
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],

                    'Access-Control-Request-Headers' => ['*'],

                    // 上面👆的 Method|Headers 配置可以被客户端缓存多久
                    // 'Access-Control-Max-Age' => 86400,

                    // 那些头部可以作为响应暴露给外部
                    // 'Access-Control-Expose-Headers' => ['*'],

                    // 'Access-Control-Allow-Origin' => ['*'], //这个跟Origin配置一个意思！
                ],
            ],
        ];
        return $behaviors;

        return ArrayHelper::merge([
            [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['*'],
                    'Access-Control-Request-Headers' => ['*'],
                ],

            ],
        ], parent::behaviors());
    }

    public function beforeAction($action)
    {

        if (isset($_REQUEST[REST_TABLE_NAME])) {
            $tableName = $_REQUEST[REST_TABLE_NAME];
            DynamicActiveRecord::setTableName($tableName);

        } else {
            DynamicActiveRecord::setTableName('user');
        }

        if ($this->db != 'db') {

            DynamicActiveRecord::setDbID($this->db);
        }

        return parent::beforeAction($action);
    }

    /**
     * 当前api使用的db组件名称 可在配置文件中配置哦 controllerMap
     *
     * @var string
     */
    public $db = 'db';
    /**
     * Undocumented variable
     *
     * @var string
     */
    public $modelClass = 'year\db\DynamicActiveRecord';

    /**
     * http://127.0.0.1:10077/my-github/YiiSpace/api/web/quick/test?table_name=admin_role
     *
     * ----------------------------------------------------------------------
     *                        可选方案： ## url 重写
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
    public function actionTest($tableName = '', $id = '')
    {
        // echo $this->db ; die(__FILE__);
        $request = \Yii::$app->request;

        $tableName = empty($tableName) ? $request->get('table_name', 'user')
        : $tableName;

        // \Yii::$app->params[REST_TABLE_NAME] = $tableName ;

        // \Yii::$app->getCache()->set(REST_TABLE_NAME,$tableName) ;
        // 意外通信线路
        $_REQUEST[REST_TABLE_NAME] = $tableName;

        // return $_REQUEST ;

        // 关闭掉外侧的结果改写 ,
        // @note 由于没有第二个参数 这样会关闭掉所有注册的事件  是比较危险的做法  ，可以把第二个参数具象化（不要使用匿名函数就OK了）
        // off 函数内部是利用 ===  比较的：  ($eventHandler === $handler)
        \Yii::$app->getResponse()->off(Response::EVENT_BEFORE_SEND);

        $httpMethod = $request->getMethod(); // GET, POST, HEAD, PUT, PATCH, DELETE.

        $request = [
            'no handler for your request ',
        ];
        switch ($httpMethod) {
            case 'GET':
                if (!empty($id)) {
                    $result = \Yii::$app->runAction('quick/view', ['id' => $id]);
                } else {
                    $result = \Yii::$app->runAction('quick/index');
                }
                break;

            case 'POST':
                $result = \Yii::$app->runAction('quick/create');
                break;

            case 'PATCH':
                $result = \Yii::$app->runAction('quick/update', ['id' => $id]);
                break;

            case 'PUT':
                $result = \Yii::$app->runAction('quick/update', ['id' => $id]);
                break;

            case 'DELETE':
                $result = \Yii::$app->runAction('quick/delete', ['id' => $id]);
                break;

            default:
//                 echo "No number between 1 and 3";
                throw new HttpException('can not handle the request by this server at ' . __FILE__);
        }
        //  return array_keys($result) ;
        return ($result);
    }

}
