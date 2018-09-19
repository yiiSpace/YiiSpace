<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/5/4
 * Time: 20:32
 */

namespace my\test\console\controllers;


use my\test\common\models\User;
use year\db\DynamicActiveRecord;
use yii\console\Controller;
use yii\db\ActiveRecord;
use yii\db\AfterSaveEvent;
use yii\db\Query;

class EsController extends Controller
{


    public function actionSeed()
    {
        $this->stdout(__METHOD__);
        /** @var Query $query */
        $query = User::find();
        foreach ($query->batch() as $users) {
            /** @var User $user */
            foreach ($users as $user) {
                // print_r($user->attributes) ;
                // echo  $user::className() ;
                $user->attachBehavior('elasticsearch', [
                    'class' => \borales\behaviors\elasticsearch\Behavior::className(), // 此扩展不错 有空可以扩展下
                    'mode' => 'command',
                    'elasticIndex' => 'yiispace', // \Yii::$app->name ,
                    'elasticType' => 'posts',
                    'dataMap'=> $user->fields() ,  // 此处可以留一个扩充点给AR 以便于他们可以自定义需要搜索的东西
                    /*
                    'dataMap' => [
                        'id' => 'id',
                        'title' => 'name',
                        'body' => function () {
                            return strip_tags($this->body);
                        },
                        'date_publish' => function () {
                            return date('U', strtotime($this->date_create));
                        },
                        'author' => function () {
                            return ucfirst($this->author->name);
                        }
                    ]
                    */
                ]);
                $user->trigger(ActiveRecord::EVENT_AFTER_INSERT,new AfterSaveEvent([
                    'changedAttributes'=>[],  // 只是一个通知 不需要传递额外数据 这里是模拟哦！！
                ]));
            }

        }
    }

    public function actionAr()
    {
        $dbSchema = \Yii::$app->db->getSchema() ;
        foreach ($dbSchema->getTableSchemas( ) as $tableSchema)
        {
            print_r($tableSchema->name) ;
            try{
                $this->seedForTable($tableSchema->name) ;
            }catch (\Exception $ex){
                $this->stderr("seed table {$tableSchema->name} to ElasticSearch failed! !") ;
                continue ;
            }
        }
    }

    protected function model2es( ActiveRecord $model)
    {
        $model->attachBehavior('elasticsearch', [
            'class' => \borales\behaviors\elasticsearch\Behavior::className(), // 此扩展不错 有空可以扩展下
            'mode' => 'command',
            'elasticIndex' => 'yiispace', // \Yii::$app->name ,
            'elasticType' => ''.$model::tableName(),
            'dataMap'=>  array_combine($model->attributes( ) ,$model->attributes() )  , // $user->fields() ,  // 此处可以留一个扩充点给AR 以便于他们可以自定义需要搜索的东西
                    /*
                    'dataMap' => [
                        'id' => 'id',
                        'title' => 'name',
                        'body' => function () {
                            return strip_tags($this->body);
                        },
                        'date_publish' => function () {
                            return date('U', strtotime($this->date_create));
                        },
                        'author' => function () {
                            return ucfirst($this->author->name);
                        }
                    ]*/
                ]);
                $model->trigger(ActiveRecord::EVENT_AFTER_INSERT,new AfterSaveEvent([
                    'changedAttributes'=>[],  // 只是一个通知 不需要传递额外数据 这里是模拟哦！！
                ]));
    }

    protected function seedForTable($tableName='')
    {
        $this->stdout("seed for table {$tableName} \n ");

        DynamicActiveRecord::setTableName($tableName) ;
        /** @var Query $query */
        $query = DynamicActiveRecord::find();
        /** @var ActiveRecord[] $models */
        foreach ($query->batch() as $models) {
            /** @var User $user */
            foreach ($models as $model) {
                //  print_r($model->attributes) ;
                // echo  $user::className() ;
                $model->attachBehavior('elasticsearch', [
                    'class' => \borales\behaviors\elasticsearch\Behavior::className(), // 此扩展不错 有空可以扩展下
                    'mode' => 'command',
                    'elasticIndex' => 'yiispace', // \Yii::$app->name ,
                    'elasticType' => ''.$tableName,
                    'dataMap'=>  array_combine($model->attributes( ) ,$model->attributes() ) , // $user->fields() ,  // 此处可以留一个扩充点给AR 以便于他们可以自定义需要搜索的东西
                    /*
                    'dataMap' => [
                        'id' => 'id',
                        'title' => 'name',
                        'body' => function () {
                            return strip_tags($this->body);
                        },
                        'date_publish' => function () {
                            return date('U', strtotime($this->date_create));
                        },
                        'author' => function () {
                            return ucfirst($this->author->name);
                        }
                    ]
                    */
                ]);
                $model->trigger(ActiveRecord::EVENT_AFTER_INSERT,new AfterSaveEvent([
                    'changedAttributes'=>[],  // 只是一个通知 不需要传递额外数据 这里是模拟哦！！
                ]));
                $this->stdout("success seed for table {$tableName} ") ;
            }
            usleep(100) ;
        }

        $this->stdout("end seed for table {$tableName} \n ") ;
        $this->stdout("------------------*************----------------------------------- \n ") ;
    }

}