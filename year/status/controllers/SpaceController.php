<?php

namespace year\status\controllers;

use yii\web\Controller;

/**
 * for user space public showing
 *
 * Class SpaceController
 * @package year\status\controllers
 */
class SpaceController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
