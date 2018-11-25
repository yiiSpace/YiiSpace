<?php

namespace my\content\backend\controllers\api;

/**
* This is the class for REST controller "ArticleCategoryController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ArticleCategoryController extends \yii\rest\ActiveController
{
public $modelClass = 'my\content\common\models\ArticleCategory';
}
