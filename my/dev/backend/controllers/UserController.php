<?php

namespace my\dev\backend\controllers;

use my\dev\common\api\ResBeforeSendBehavior;
use Yii;
use my\dev\common\models\User;

class UserController extends \yii\rest\ActiveController
{
    /**
     * NOTE: 格式如果还不满意 可以自己继承Serializer 然后再配置为新的子类即可
     */
     public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items'
    ];

    public $modelClass = User::class;


    public $enableCsrfValidation = false;

    public function beforeAction($action)
    {
        /** @var yii\base\Application */
        $app = \Yii::$app;
        $app->getResponse()->attachBehavior('as resBeforeSend', [
            'class'         =>  ResBeforeSendBehavior::class,
            'defaultCode'   => 500,
            'defaultMsg'    => 'error',
        ]);
        //Yii::$app->attatchBehavior()

        return parent::beforeAction($action);
    }
}
