<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-7-29
 * Time: 下午7:02
 */

namespace year\user\controllers;


class SpaceController extends Controller{

    /**
     * @var string
     */
    public $layout = 'space';

    public function actionIndex()
    {
        return $this->render('index');

    }
} 