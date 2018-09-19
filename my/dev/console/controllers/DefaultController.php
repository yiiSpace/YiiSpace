<?php
namespace my\dev\console\controllers;

use yii\console\Controller;
use yii\console\ExitCode;


/**
 * Default controller for the `dev` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->stdout(__METHOD__) ;
        return ExitCode::OK;
    }
}
