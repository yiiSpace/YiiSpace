<?php

namespace my\js\frontend\controllers;

use yii\base\ViewEvent;
use yii\web\Controller;

/**
 * Es6Controller controller for the `js` module
 */
class Es6Controller extends Controller
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
