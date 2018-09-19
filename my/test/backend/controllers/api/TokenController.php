<?php

namespace my\test\backend\controllers\api;

/**
* This is the class for REST controller "TokenController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class TokenController extends \yii\rest\ActiveController
{
public $modelClass = 'my\test\common\models\Token';
}
