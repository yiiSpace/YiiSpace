<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/3/16
 * Time: 14:59
 */

namespace my\devtools\backend\controllers;


use yii\data\ArrayDataProvider;
use yii\db\TableSchema;
use yii\web\Controller;

class DbController extends Controller
{

    public function actionIndex()
    {
        $dbSchema = \Yii::$app->db->getSchema();

        $tables = $dbSchema->getTableSchemas();
        $func = function(TableSchema $table)  {
//            return $value * 2;
            return [
                'id'=>$table->fullName ,
                'schemaName'=> $table->schemaName,
                'name'=> $table->name,
                'tableSchema'=> $table,
            ] ;
        };
        // array_map 可以执行zip ：很神奇：https://www.php.net/manual/en/function.array-map.php
        $allModels = array_map($func,  $tables ) ;

        $dataProvider = new ArrayDataProvider([
            'allModels'=> $allModels,
            'key'=>'id',
//            'sort' => [
//                'attributes' => ['city', 'year'],
//            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index',[
//            'dbSchema'=>$dbSchema,
            'dataProvider'=>$dataProvider,
        ]) ;
    }

    public function actionFacker()
    {
        return $this->render('form4facker');
    }
}