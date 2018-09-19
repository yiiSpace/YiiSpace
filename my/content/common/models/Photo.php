<?php

namespace my\content\common\models;

use Yii;
use \my\content\common\models\base\Photo as BasePhoto;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "content_photo".
 */
class Photo extends BasePhoto
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}
