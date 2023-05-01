<?php

namespace my\php\frontend\controllers;

use my\php\common\features\TraitsDemo;
use year\migration\GeneratorTrait;
use yii\web\Controller;

// 临时用下哈
use \yii\db\Connection;
use yii\di\Instance;

/**
 * Default controller for the `php` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     * 
     * 错误出现：“Headers already sent” 
     * Try not to echo anything. In general don’t echo in controllers.
     * 
     * Since Yii 2.0.14 you cannot echo in a controller. A response must be returned:
     * 
     * You may also call `exit` at the end of your method to prevent further processing or wrap your code with ob_start() and ob_get_clean(),
     * if you're not able to avoid echo.
     * 
     */
    public function actionIndex()
    {

        ob_start();

        TraitsDemo::run();

        return ob_get_clean();



        // return $this->render('index');
    }

    use GeneratorTrait;

    public function actionMigrate()
    {

        // todo : 原作者是在beforAction中 实例化db的  $
        $this->db = Instance::ensure($this->db, Connection::class);
        $generator = $this->getGenerator();
        dump($generator) ; exit(0) ;
    }
}