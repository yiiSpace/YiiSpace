<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/14
 * Time: 13:41
 */

namespace api\controllers;


use yii\rest\Controller;

/**
 * 这是网站首页api
 *
 * Class SiteController
 * @package api\controllers
 */
class SiteController extends Controller{

    /**
     * @return string
     */
    public function actionIndex()
    {
        return 'it works !';
    }
}