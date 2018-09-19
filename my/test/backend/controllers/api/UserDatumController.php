<?php

namespace my\test\backend\controllers\api;

/**
* This is the class for REST controller "UserDatumController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class UserDatumController extends \yii\rest\ActiveController
{
public $modelClass = 'my\test\common\models\UserDatum';
}
