<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/12/9
 * Time: 15:12
 */

namespace my\content\api\controllers;


use my\content\services\AlbumService;
use year\api\rest\ActiveController;
use year\api\rest\Controller;
use year\api\service\ServiceExecutor;

class AlbumController extends  Controller  // ActiveController
{

    public $serviceClass = 'my\content\services\AlbumService' ;

    /**
     * @return ServiceExecutor
     */
    protected function getServiceExecutor()
    {
        $serviceExecutor = new ServiceExecutor();
        $serviceExecutor->setServiceClass( $this->serviceClass ) ;
        return $serviceExecutor ;
    }

    /**
     *
     */
    public function actionIndex()
    {
        // $serviceObj = new AlbumService() ;
        
        $serviceExecutor = new ServiceExecutor();
        $serviceExecutor->setServiceClass( AlbumService::class ) ;
        
        return $serviceExecutor->invoke('query' , \Yii::$app->request->get()) ; //  $serviceObj->query()
    }

    /**
     * Displays a single Album model.
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->getServiceExecutor()
            ->invoke('get',['id'=>$id]) ;
    }


    /**
     * Creates a new Album model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // print_r($_POST) ; die(__METHOD__) ; // NOTE json解析时  不要用$_POST
        return $this->getServiceExecutor()
            ->invoke('create',\Yii::$app->request->post()) ;
    }
    /**
     * Updates an existing Album model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        return $this->getServiceExecutor()
            ->invoke('update',['id'=>$id]+\Yii::$app->request->post()) ;
    }

    /**
     * Deletes an existing Album model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        return $this->getServiceExecutor()
            ->invoke('delete', ['id'=>$id]) ;
    }
}