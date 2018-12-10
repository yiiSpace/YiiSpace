<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/12/10
 * Time: 11:42
 */

namespace year\api\rest;


use year\api\rest\Controller;
use year\api\service\ServiceMethodExecutor;

/**
 * Class CrudController
 * @package year\api\rest
 */
class CrudController extends Controller
{

    /**
     * @var string
     */
    public $serviceClass  ;

    /**
     *
     */
    public function init()
    {
        parent::init();
        if ($this->serviceClass === null) {
            throw new InvalidConfigException('The "serviceClass" property must be set.');
        }
    }

    /**
     * @return ServiceMethodExecutor
     */
    protected function getServiceMethodExecutor()
    {
        $serviceExecutor = new ServiceMethodExecutor();
        $serviceExecutor->setServiceClass( $this->serviceClass ) ;
        return $serviceExecutor ;
    }

    /**
     *
     */
    public function actionIndex()
    {

        $serviceExecutor = $this->getServiceMethodExecutor();

        return $serviceExecutor->invoke('query' , \Yii::$app->request->get()) ; //  $serviceObj->query()
    }

    /**
     * Displays a single  model.
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->getServiceMethodExecutor()
            ->invoke('get',['id'=>$id]) ;
    }


    /**
     * Creates a new  model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // print_r($_POST) ; die(__METHOD__) ; // NOTE json解析时  不要用$_POST
        return $this->getServiceMethodExecutor()
            ->invoke('create',\Yii::$app->request->post()) ;
    }

    /**
     * Updates an existing   model.
     * @param integer $id
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id)
    {

        return $this->getServiceMethodExecutor()
            ->invoke('update',['id'=>$id]+\Yii::$app->request->post()) ;
    }

    /**
     * Deletes an existing  model.
     * @param integer $id
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionDelete($id)
    {

        return $this->getServiceMethodExecutor()
            ->invoke('delete', ['id'=>$id]) ;
    }
}