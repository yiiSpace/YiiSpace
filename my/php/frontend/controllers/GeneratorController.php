<?php

namespace my\php\frontend\controllers;

use my\php\common\features\GeneratorDemo;
use yii\web\Controller;

class GeneratorController extends Controller
{

    public function actionIndex()
    {
        ob_start();
        GeneratorDemo::run();
        $content = ob_get_clean() ;

        return $this->renderContent($content) ;
    }

}