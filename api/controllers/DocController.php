<?php
/**
 * Created by PhpStorm.
 * User: guruYu
 * Date: 2018/12/17
 * Time: 15:07
 */

namespace api\controllers;


use yii\rest\Controller;

class DocController extends Controller
{

    public function actionIndex()
    {
        $path = \Yii::getAlias('@api/controllers');
        $path = '..' ;
        $openapi = \OpenApi\scan($path);
        // header('Content-Type: application/x-yaml');
        return  [
             $path
            ];
    }

}