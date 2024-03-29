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
    public function actionScope()
    {
        return $this->render('scope');
    }
    public function actionDestruction()
    {
        return $this->render('destruction');
    }
    public function actionDestruction2()
    {
        return $this->render('destruction2');
        
    }
    public function actionFunc()
    {
        return $this->render('func');
        
    }
    public function actionFunc2()
    {
        return $this->render('func2');
        
    }
    public function actionFuncThis()
    {
        return $this->render('func-this');
        
    }
    public function actionArrowFunc()
    {
        return $this->render('arrow-func');
        
    }
    public function actionStr()
    {
        return $this->render('str');
        
    }
    public function actionRegex()
    {
        return $this->render('regex');
        
    }
    public function actionMath()
    {
        return $this->render('math');
        
    }
    public function actionArray()
    {
        return $this->render('array');
        
    }
    public function actionObject()
    {
        return $this->render('object');
        
    }
    public function actionSymbol()
    {
        return $this->render('symbol');
    }
    public function actionSet()
    {
        return $this->render('set');
    }
    public function actionMap()
    {
        return $this->render('map');
    }
    public function actionIterator()
    {
        return $this->render('iterator');
    }
    public function actionPromise()
    {
        return $this->render('promise');
    }
    public function actionProxy()
    {
        return $this->render('proxy');
    }
    public function actionAsync()
    {
        return $this->render('async');
    }
    public function actionClass()
    {
        return $this->render('class');
    }
    public function actionModule()
    {
        return $this->render('module');
    }

    
}
