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
        $rules = [
            [['owner_id', 'album_id'], 'integer'],
            [['desc'], 'string'],

            [['title', 'ext', 'size'], 'string', 'max' => 255],
            [['hash'], 'string', 'max' => 32],
            [['hash'], 'unique']
        ] ;

        // 不出现在验证规则中的属性 是不会被批量赋值的
        if($this->getIsNewRecord()){
            // 文件图片上传 更新时是允许不传图片的
          $rules[] =    [['uri', ], 'file', 'extensions' => 'jpeg,jpg, gif, png',
                'skipOnEmpty' => !$this->getIsNewRecord()
            ];
        }

        return $rules ;
    }



    /**
     *
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            if(!empty($this->uri)){
                $this->hash = md5($this->uri);
            }
        } else {
            if($this->isAttributeChanged('uri')){
                $this->hash = md5($this->uri);
            }
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if($insert){
            /** @var Album $album */
            $album = $this->album ;
            if(!empty($album) && empty($album->cover_uri)){
                $album->cover_uri = $this->uri ;
                $album->save(false) ;
            }
        }

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(Album::className(),[
           'id'=>'album_id',
        ]);
    }
    /**
     * 获取图片的可访问url地址
     *
     * @return string
     */
    public function getUrl()
    {
        /**
         * @var \year\upload\UploadStorageInterface $uploadStorage
         */
        $uploadStorage = \Yii::$app->get('uploadStorage');
        $imgUrl = $uploadStorage->getPublicUrl($this->uri);
        return $imgUrl ;
    }

}
