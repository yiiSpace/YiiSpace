<?php

namespace my\dev\api\controllers;
use my\dev\common\models\User;

class UserController extends \yii\rest\ActiveController
{ 

    public $modelClass = User::class;

}
