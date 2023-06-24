<?php
namespace backend\controllers;

use backend\components\DbMan;
use common\components\ConsoleAppHelper;
use year\db\DynamicActiveRecord;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','console','strange','vue'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        // die(__METHOD__) ;
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        // 布局采用的是登陆布局
        $this->layout = 'login' ;

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            // Todo : 这里先用的假用户哦
            $model->username = 'admin';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return array
     */
    function returnConfig()
    {

            return \yii\helpers\ArrayHelper::merge(
                require( \Yii::getAlias('@common/config/main.php')),
                require( \Yii::getAlias('@console/config/main.php'))
            );

    }
    public function actionStrange()
    {
        dump(get_defined_vars());
//        $config1 = $this->returnConfig() ;
//        //
////        dump($params);
//        echo '====';
//        dump(get_defined_vars());
        // 这样也不行！！！ 不调用都不行
        $config2 = (function (){
            return \yii\helpers\ArrayHelper::merge(
                require( \Yii::getAlias('@common/config/main.php')),
                require( \Yii::getAlias('@console/config/main.php'))
            );
        })();
        echo ' immediate function call ';
        dump(get_defined_vars());

        $config = \yii\helpers\ArrayHelper::merge(
            require( \Yii::getAlias('@common/config/main.php')),
            require( \Yii::getAlias('@console/config/main.php'))
        );
        echo 'after bare require some files: ' ;
        dump(get_defined_vars());
        // 这个params 是来自被require文件中的东西 在IDE中就报错
        dump($params);

        echo '====' ;
        dump(Yii::$app->params) ;
        exit(0) ;
    }
    public function actionConsole($params= 'something')
    {


        $oldApp = Yii::$app ;
        $callback = function(\yii\console\Application $consoleApp)use($oldApp){
            // \Yii::trace( "ahahahhahahahhhahah", 'console' );
            // \Yii::debug('sjdfksdjflsjdkfklsdfjl','console');
            // \Yii::error( 'sjdfksdjflsjdkfklsdfjl','console');
            // \Yii::debug('sjdfksdjflsjdkfklsdfjl','console');
            // use current connection to DB
             \Yii::$app->set( 'db', $oldApp->db );
             $db = \Yii::$app->getDb() ;
             $db->getDriverName() ; // TODO 根据不同的driver 实现不同的查询哦
             $cmd = $db->createCommand('SHOW DATABASES') ;

             $dbs =  $cmd->queryColumn() ;
             \Yii::error( implode(',',$dbs),'console');


            /**
             * var DbMan $dbMan
             *  */
          $dbMan = $oldApp->get('dbMan') ;
            $dbMan->bootstrap($consoleApp);
//
           $componentDefinitions = $consoleApp->getComponents(true);
//
//            \Yii::error( print_r($componentDefinitions,true),'console');
//

        };

//        php yii gii/model --tableName=page_resource --modelClass=PageResource --ns="backend\models" --queryClass=PageResource --queryNs="backend\models\query"


//       $result = ConsoleAppHelper::runAction('hello/to',[],$callback);
       $result = ConsoleAppHelper::runAction('gii/model',[
           'tableName'=>'user',
           'modelClass'=>'User2',
           'ns'=>'runtime\models',
           'queryClass'=>'UserQuery2',
           'queryNs'=>"backend\models\query",
//           'interactive' => false,

       ],$callback);

       $dbId = DbMan::getDbId('tpshop') ;
       $table = 'tp_users' ;

       DynamicActiveRecord::setDbID($dbId);
       DynamicActiveRecord::setTableName('tp_users');

       $result = ConsoleAppHelper::runAction('gii/crud',[
           'controllerClass'=>DynamicController::class,
           'modelClass'=>DynamicActiveRecord::class,
           'viewPath'=>"@backend/runtime/dynamic/views/{$dbId}/{$table}",

       ],$callback);

    //    $this->renderContent($result) ;
//        return $this->renderContent(dump($result));

        DynamicController::$dbID = $dbId ;
        DynamicController::$tableName = $table ;
//        return \Yii::$app->runAction('dynamic/index',[]);
        return \Yii::$app->runAction('dynamic/create',[]);
    }


    /**
     * Undocumented function
     *
     * NOTE: 有些css js使用cdn的话 尽量选择国内大厂 比如
     * https://www.bootcdn.cn/vuex/
     * 国外的网站可能不能访问到哦😯！
     * 
     * @param [type] $sfc
     * @return void
     * 
     * 可用路由：
     * - r=site/vue&to=vue-pinia
     * - r=site/vue&sfc=true
     * - r=site/vue&sfc=router
     * - r=site/vue&sfc=form
     * - r=site/vue&sfc=vue-components
     * - r=site/vue&sfc=vue-vuex
     */
    public function actionVue($sfc=null,$router=null, $form=null,$to='')
    {
        if(!empty($to)){
            return $this->render($to);
        }
        
        if(!empty($form)){
            return $this->render('vue-form');
        }
        if(!empty($router)){
            return $this->render('vue-router');
        }

        if(!empty($sfc)){
            return $this->render('vue-sfc');
        }
        return $this->render('vue');
    }
}
