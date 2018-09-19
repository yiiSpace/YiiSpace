<?php

namespace my\content\backend\controllers\api;

/**
* This is the class for REST controller "AlbumController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class AlbumController extends \yii\rest\ActiveController
{
public $modelClass = 'my\content\common\models\Album';
}
