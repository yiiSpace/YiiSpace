<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/4/16
 * Time: 13:11
 */

namespace my\test\console\controllers;


use Faker\Factory;
use my\test\search\xunsearch\models\Demo;
use yii\console\Controller;
use yii\data\ActiveDataProvider;

class XsController extends Controller
{

    public function actionDemo()
    {
        $this->stdout(__METHOD__);

        $db = \Yii::$app->xunsearch->getDatabase('demo');
        // $db = (\Yii::$app->xunsearch)('demo');
        $xs = $db->xs;
        $search = $db->getSearch();
        $index = $db->getIndex();

        print_r([
            $search,
            $index,
        ]);

        // 添加索引，也可以通过 $model->setAttributes([...]) 批量赋值
        $model = new Demo();
        $model->pid = 321;
        $model->subject = 'hello world';
        $model->message = 'just for testing...';
        $model->save();
        /*
        // 更新索引
                $model = Demo::findOne(321);
                $model->message .= ' + updated';
                $model->save();


        // 添加或更新索引还支持以方法添加索引词或文本
        // 这样做的目的是使得可以通过这些关键词检索到数据，但并非数据的字段值
        // 用法与 XSDocument::addTerm() 和 XSDocument::addIndex() 等同
        // 通常在 ActiveRecord::beforeSave() 中做这些操作
                $model->addTerm('subject', 'hi');
                $model->addIndex('subject', '你好，世界');

        // 如需删除数据则可直接
                $model->delete();

        */
    }

    public function actionFind()
    {
        $query = Demo::find(); // 返回 ActiveQuery 对象
        $condition = 'hello world';    // 字符串原样保持，可包含 subject:xxx 这种形式
        /*
        $condition = ['WILD', 'key1', 'key2' ... ];	// 通过空格将多个查询条件连接
$condition = ['AND', 'key1', 'key2' ... ]; // 通过 AND 连接，转换为：key1 AND key2
$condition = ['OR', 'key1', 'key2' ... ]; // 通过 OR 连接
$condition = ['XOR', 'key1', 'key2' ... ]; // 通过  XOR 连接
$condition = ['NOT', 'key']; // 排除匹配 key 的结果
$condition = ['pid' => '123', 'subject' => 'hello']; // 转换为：pid:123 subject:hello
$condition = ['pid' => ['123', '456']]; // 相当于 IN，转换为：pid:123 OR pid:456
$condition = ['IN', 'pid', ['123', '456']]; // 转换结果同上
$condition = ['NOT IN', 'pid', ['123', '456']]; // 转换为：NOT (pid:123 OR pid:456)
$condition = ['BETWEEN', 'chrono', 14918161631, 15918161631]; // 相当于 XSSearch::addRange(...)
$condition = ['WEIGHT', 'subject', 'hello', 0.5]; // 相当于额外调用 XSSearch::addWeight('subject', 'hello', 0.5);
        */
        $query->where($condition);
        $all = $query->all();
        print_r($all);
    }

    public function actionSeed()
    {

        // $faker = Faker\Factory::create();
        $faker = Factory::create('zh_CN');

        for ($i = 0; $i <= 10000; $i++) {
            $model = new Demo();
            $model->pid = $i;
            $model->subject = $faker->name;
            $model->message = $faker->text;
            $model->save();

            if ($i % 100 == 0) {
                $this->stdout('the row num is ' . $i);
                sleep(2);
            }
            unset($model);
        }


    }

    public function actionPage($page=0)
    {
        $query = Demo::find(); // 返回 ActiveQuery 对象
        // $condition = 'hello world';    // 字符串原样保持，可包含 subject:xxx 这种形式
        /*
        $condition = ['WILD', 'key1', 'key2' ... ];	// 通过空格将多个查询条件连接
        $condition = ['AND', 'key1', 'key2' ... ]; // 通过 AND 连接，转换为：key1 AND key2
        $condition = ['OR', 'key1', 'key2' ... ]; // 通过 OR 连接
        $condition = ['XOR', 'key1', 'key2' ... ]; // 通过  XOR 连接
        $condition = ['NOT', 'key']; // 排除匹配 key 的结果
        $condition = ['pid' => '123', 'subject' => 'hello']; // 转换为：pid:123 subject:hello
        $condition = ['pid' => ['123', '456']]; // 相当于 IN，转换为：pid:123 OR pid:456
        $condition = ['IN', 'pid', ['123', '456']]; // 转换结果同上
        $condition = ['NOT IN', 'pid', ['123', '456']]; // 转换为：NOT (pid:123 OR pid:456)
        $condition = ['BETWEEN', 'chrono', 14918161631, 15918161631]; // 相当于 XSSearch::addRange(...)
        $condition = ['WEIGHT', 'subject', 'hello', 0.5]; // 相当于额外调用 XSSearch::addWeight('subject', 'hello', 0.5);
                */
        // $query->where($condition);
        $dataProvider = new ActiveDataProvider() ;
        $dataProvider->query = $query ;

        $dataProvider->pagination->setPage($page) ;

        $dataSet = $dataProvider->getModels();

        foreach ($dataSet as $model)
        {
            print_r(
              $model->toArray()
            );
        }
    }


}