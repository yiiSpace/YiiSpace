<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/28
 * Time: 0:12
 */

namespace api\controllers;


use year\base\DynamicModel;
use yii\helpers\StringHelper;
use yii\rest\Controller;

/**
 * 这是样例api
 *
 * API的原型无外乎 增删改查 --即CRUD 操作  只要所有的业务逻辑映射到此几种操作即可
 * -  Create :  新增操作
 * -  Update :  更新操作
 * -  Delete :  删除操作
 * -  Read   :  查询操作
 *      -  单条记录的读操作   view($id) :  ActiveRecord|array  入参是实体id  返回一个活动记录或者数组即可
 *      -  topN查询           latestXxx($limit=5) : array      返回topN查询 数组类型
 *      -  分页类型           list() : array|DataProvider      返回数据提供者 Yii的rest包自带序列化功能
 *
 * Class SampleController
 * @package api\controllers
 */
class SampleController extends Controller{

    /**
     * @return DynamicModel|\yii\data\ArrayDataProvider
     * @throws BadRequestHttpException
     */
    public function actionTest()
    {

        // throw new ValidationException('there is some error');
        $dp = \api\helpers\Dev::fakeProvider([
            ['name'=>'yiqing',],
            ['name'=>'yiqing2',],
            ['name'=>'yiqing2',],
            ['name'=>'yiqing2',],
            ['name'=>'yiqing2',],
        ]) ;


        $dp->pagination->setPageSize(2) ;
        return $dp ;


        $model = new DynamicModel([
            'attr1'=>'value1',
            'attr2'=>'value2',
            'attr3'=>'',

        ]);
        $model->addError('attr1','there is error') ;
        $model->addError('attr1','there is error2') ;
        $model->addError('attr2','there is error3') ;

        // $model->addRule('attr3', 'required')->validate();


        return $model ;

     throw new BadRequestHttpException() ;
//        throw new BadRequestHttpException() ;
        // throw new ForbiddenHttpException() ;
//        throw new UnauthorizedHttpException();

    }

    /**
     * @PostParams string $p   描述
     * @PostParams string $p   jjllll
     * @PostParams string $p=""   也是描述
     * @PostParams string $p --optional  也是描述
     * @PostParams( string, p,true,'好吧阿 ',"看看会出现啥情况) ")
     *
     * @param string $p  这是get请求的参数 其余描述可以加呢
     * 还可以换行哦
     * @return array
     */
    public function actionCreate($p)
    {
       // return __METHOD__ ;
        return [
          'id'=>uniqid('usr') ,
            'created_at'=>time(),
        ];
    }

    /**
     * 更新操作
     *
     * @param $id  实体id
     * @param $newName  新名称
     * @return array
     */
    public function actionUpdate($id , $newName)
    {
        // return __METHOD__ ;
        return [
            'id'=>uniqid('usr') ,
            'updated_at'=>time(),
        ];
    }
    /**
     * @param string $name
     * @param int $sex
     * @return DynamicModel
     */
    public function actionCreateFailed($name='',$sex=1)
    {

        $model = new DynamicModel([
            'name'=>'44444d',
            'sex'=>null,
        ]);
        $model->addRule('name','string',['length'=>6,])->validate();

        if($model->hasErrors()){
            return $model ;
        }else{
            return true ;
        }
    }

    /**
     * 删除操作
     *
     * @param $id
     * @return array
     */
    public function actionDelete($id)
    {
        // 执行删除操作
        // return __METHOD__ ;
        return [
            'deleted_at'=>time(),
        ];
    }


    /**
     * @return \yii\data\ArrayDataProvider
     */
    public function actionTopn()
    {
        // throw new ValidationException('there is some error');
        $dp = \api\helpers\Dev::fakeProvider([
            ['name'=>'yiqing',],
            ['name'=>'yiqing1',],
            ['name'=>'yiqing2',],
            ['name'=>'yiqing3',],
            ['name'=>'yiqing24',],
        ]) ;


        $dp->pagination->setPageSize(2) ;
        return $dp ;
    }

    /**
     * @param int $p  页码
     * @return \yii\data\ArrayDataProvider
     */
    public function actionList($p=0)
    {
        // throw new ValidationException('there is some error');
        $dp = \api\helpers\Dev::fakeProvider([
            ['name'=>'yiqing',],
            ['name'=>'yiqing1',],
            ['name'=>'yiqing2',],
            ['name'=>'yiqing3',],
            ['name'=>'yiqing24',],
        ]) ;


        $dp->pagination->setPageSize(2) ;
        $dp->pagination->setPage($p) ;
        return $dp ;
    }
}