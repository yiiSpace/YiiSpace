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

    public function getPhotos()
    {
        return $this->hasMany(\my\content\common\models\base\Photo::className(),[
           'album_id'=>'id'
        ]);
    }

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
        /**
         * @var \year\upload\UploadStorageInterface $uploadStorage
         */
        $uploadStorage = \Yii::$app->get('uploadStorage');
        $imgUrl = $uploadStorage->getPublicUrl($this->cover_uri);
        return $imgUrl ;
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
