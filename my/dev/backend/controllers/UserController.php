<?php

namespace my\dev\backend\controllers;

use my\dev\common\api\ResBeforeSendBehavior;
use Yii ;
use my\dev\common\models\User;

class UserController extends \yii\rest\ActiveController
{ 
    public $serializer = [
         'class'=>'yii\rest\Serializer',
          'collectionEnvelope'=>'items'
         ]; 

    public $modelClass = User::class;


    public $enableCsrfValidation = false;

    public function beforeAction($action)
    {
        /** @var yii\base\Application */
        $app = \Yii::$app ;
        $app->getResponse()->attachBehavior('as resBeforeSend',[
            'class'         =>  ResBeforeSendBehavior::class,
            'defaultCode'   => 500,
            'defaultMsg'    => 'error',
        ]);
        //Yii::$app->attatchBehavior()

        return parent::beforeAction($action);
    }
}
