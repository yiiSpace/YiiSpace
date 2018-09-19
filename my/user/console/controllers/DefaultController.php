<?php

namespace my\user\console\controllers;


use yii\console\Controller;

class DefaultController extends Controller
{

    /**
     * @var string default action.
     */
    public $defaultAction = 'create';

    /**
     * TODO
     * Creates a new account with the given username and password.
     *
     * @param string $username desired username.
     * @param string $password desired password.
     * @return integer exit code.
     * @throws Exception
     */
    public function actionCreate($username, $password)
    {


        return 0;
    }


    public function actionIndex()
    {
       $this->stdout(__METHOD__) ;
    }
}
