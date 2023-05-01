<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/9/21
 * Time: 14:14
 */

namespace backend\components;


use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Component;

/**
 * should refer the Chive yii-project
 *
 * Class DbMan
 * @package backend\components
 */
class DbMan extends Component
implements BootstrapInterface
{

    const DB_ID_PREFIX = 'db_' ;
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        // TODO: Implement bootstrap() method.
        // print_r($this->getDatabases()) ;
        // die(__METHOD__) ;
        $dbNames = $this->getDatabases() ;
        $dbConfigList = [] ;
        /**
         *   'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=yii_space', //getenv('DB_DSN'),
        'username' => 'root', // getenv('DB_USERNAME'),
        'password' => '', // getenv('DB_PASSWORD'),
        'charset' => 'utf8',
        ],
         */
        foreach ($dbNames as $dbName){
            // TODO 需要root 权限才能获取所有数据库查询权！
            $dbConfigList[static::DB_ID_PREFIX.$dbName] = [
                'class' => 'yii\db\Connection',
//                'dsn' => 'mysql:host=localhost;dbname=yii_space', //getenv('DB_DSN'),
//                'dsn' => "mysql:host=localhost;dbname={$dbName}", //getenv('DB_DSN'),
                'dsn' => "mysql:host=127.0.0.1;dbname={$dbName}", //getenv('DB_DSN'),
                'username' =>  getenv('DB_USERNAME'),
//                'password' => '', // getenv('DB_PASSWORD'),
                'password' =>  getenv('DB_PASSWORD'),
                'charset' => 'utf8',
            ];
        }
//        注册数据库组件
        $app->setComponents($dbConfigList);
    }


    /**
     * todo: add cache！
     *
     * @return array|\yii\db\DataReader
     * @throws \yii\db\Exception
     */
    public function getDatabases()
    {
        $db = \Yii::$app->getDb() ;
        $db->getDriverName() ; // TODO 根据不同的driver 实现不同的查询哦
        $cmd = $db->createCommand('SHOW DATABASES') ;

        return  $cmd->queryColumn() ;

    }
}