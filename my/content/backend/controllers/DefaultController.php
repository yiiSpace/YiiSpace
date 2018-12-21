<?php

namespace my\content\backend\controllers;

use yii\web\Controller;

/**
 * Default controller for the `content` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionImageUpload()
    {
        return $this->asJson( \Yii::$app->request->post() );
    }
}
