<?php

namespace my\php\frontend\controllers;


use yii\web\Controller;

/**
 * 测试php 匿名类
 *
 * @see https://www.php.net/manual/en/language.oop5.anonymous.php
 */
class AnonymousController extends Controller
{
    public $layout = 'php' ;
    public function actionIndex()
    {
       return $this->renderContent('hi'.__METHOD__) ;
    }

}