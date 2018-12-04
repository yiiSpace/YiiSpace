<?php

namespace my\devtools\backend\controllers;

use my\devtools\common\models\ApiProvider;

class ApiController extends \yii\web\Controller
{
    public function actionIndex()
    {



        $model = new ApiProvider() ;

        if ($model->load(\Yii::$app->request->post()) ) {

            // 什么都不做 就是收集输入
        }
        return $this->render('index',[
            'model'=>$model,
        ]);
    }

}
