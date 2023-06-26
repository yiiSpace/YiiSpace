<?php

namespace my\js\frontend\controllers;

use yii\web\Controller;

/**
 * Default controller for the `js` module
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

    public function actionWangEditor()
    {
        return $this->render('wang-editor') ;
    }
    public function actionPrismDemo()
    {
        return $this->render('prism-demo') ;
    }
}
