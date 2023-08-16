<?php

namespace my\js\frontend\controllers;

use yii\base\ViewEvent;
use yii\web\Controller;

/**
 * Es6Controller controller for the `js` module
 */
class Es6PrimerController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');
    }
  
    public function actionLetConst()
    {

        return $this->render('let-const');
    }
    public function actionReflect()
    {

        return $this->render('reflect');
    }
    public function actionDestructuring()
    {

        return $this->render('destructuring');
    }
    public function actionDestructuring2()
    {

        return $this->render('destructuring2');
    }
    public function actionString()
    {

        return $this->render('string');
    }
  
    
    
}
