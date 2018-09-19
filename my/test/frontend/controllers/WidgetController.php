<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/7
 * Time: 11:38
 */

namespace my\test\frontend\controllers;


use yii\web\Controller;

class WidgetController extends Controller{


    public function action2markdown()
    {
        return $this->render('to-markdown');
    }
}