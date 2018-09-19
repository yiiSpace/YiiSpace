<?php

namespace my\content\common\models;

use Yii;
use \my\content\common\models\base\Album as BaseAlbum;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "content_album".
 */
class Album extends BaseAlbum
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

    public function getCoverUrl()
    {
        if(empty($this->cover_uri)){
            // return \Yii::$app->assetManager->getPublishedUrl('@admin/assets/my').'/images/album-cover.jpg';
            return 'http://temp.im/754x754/ccc' ;
        }
        return $this->cover_uri ;
    }

    /**
     * 用于photo 创建或者修改时的选择用
     *
     * @return array
     */
    public static function forPhotoDropDownSelection()
    {
        return ArrayHelper::map(
            static::find()->asArray()->all(),
            'id',
            'name'
        );
    }
}
