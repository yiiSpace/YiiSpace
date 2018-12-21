<?php

namespace my\org\backend\controllers;

use yii\web\Controller;

/**
 * Default controller for the `org` module
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
}
