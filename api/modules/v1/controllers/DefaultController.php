<?php

namespace api\modules\v1\controllers;

use yii\rest\Controller;

/**
 * Default controller for the `content` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return 'hi '.__METHOD__;
    }
}
