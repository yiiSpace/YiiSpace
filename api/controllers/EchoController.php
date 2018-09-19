<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/7/26
 * Time: 5:09
 */

namespace api\controllers;


use yii\rest\Controller;
use yii\web\BadRequestHttpException;

/**
 * Class EchoController
 * @package api\controllers
 */
class EchoController extends Controller
{


    /**
     * @return array|mixed
     * @throws BadRequestHttpException
     */
    public function actionGet()
{
    $request = \Yii::$app->request ;
    if($request->getIsGet()){
        return $request->get();
    }else{
        throw new BadRequestHttpException();
    }
}

    /**
     * @return array|mixed
     * @throws BadRequestHttpException
     */
    public function actionPost()
    {
        $request = \Yii::$app->request ;
        if($request->getIsPost()){
            return $request->post();
        }else{
            throw new BadRequestHttpException();
        }
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionPut()
    {
        $request = \Yii::$app->request ;
        if($request->getIsPut()){
            return $request->getRawBody();
        }else{
            throw new BadRequestHttpException();
        }
    }
}