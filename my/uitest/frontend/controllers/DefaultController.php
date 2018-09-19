<?php

namespace my\uitest\frontend\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    /**
     * @var string
     */
    public $layout = 'main';

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionForm()
    {

        $request = \Yii::$app->request ;
        if($request->getIsPost()){
           return $this->renderContent( print_r($request->post(),true) ) ;
        }

        return $this->render('form');
    }
}
