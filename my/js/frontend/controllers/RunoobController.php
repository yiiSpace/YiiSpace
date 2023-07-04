<?php

namespace my\js\frontend\controllers;

use yii\base\ViewEvent;
use yii\web\Controller;

/**
 * RunoobController controller for the `js` module
 * 
 * @see https://www.runoob.com/jsref/jsref-random.html
 */
class RunoobController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionArray()
    {
        return $this->render('array');
    }
   
    
    public function actionPromise()
    {
        return $this->render('promise');
    }

    
}
