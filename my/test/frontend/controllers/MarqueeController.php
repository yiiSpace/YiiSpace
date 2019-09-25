<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/7/3
 * Time: 17:39
 */

namespace my\test\frontend\controllers;


use yii\web\Controller;

class MarqueeController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index',[

        ]);
    }
    public function actionLimarquee()
    {
        return $this->render('limarquee',[

        ]);
    }

}