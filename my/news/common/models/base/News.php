<?php

namespace my\news\common\models\base;

use Yii;

/**
 * This is the base-model class for table "tbl_news".
 *
 * @property string $id
 * @property string $category_id
 * @property string $area_id
 * @property integer $level
 * @property string $title
 * @property string $subtitle
 * @property string $style
 * @property double $fee
 * @property string $introduce
 * @property string $tag
 * @property string $keyword
 * @property string $ppt_word
 * @property string $author
 * @property string $origin_from
 * @property string $origin_url
 * @property string $views
 * @property string $thumb
 * @property string $creator_name
 * @property string $create_time
 * @property string $editor_name
 * @property string $update_time
 * @property string $ip
 * @property string $template
 * @property integer $status
 * @property integer $is_link
 * @property string $link_url
 * @property string $file_path
 * @property string $note
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'area_id', 'level', 'views', 'create_time', 'update_time', 'status', 'is_link'], 'integer'],
            [['subtitle'], 'required'],
            [['subtitle'], 'string'],
            [['fee'], 'number'],
            [['title', 'tag'], 'string', 'max' => 100],
            [['style', 'author', 'ip'], 'string', 'max' => 50],
            [['introduce', 'keyword', 'ppt_word', 'origin_url', 'thumb', 'link_url', 'file_path', 'note'], 'string', 'max' => 255],
            [['origin_from', 'creator_name', 'editor_name', 'template'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'area_id' => Yii::t('app', 'Area ID'),
            'level' => Yii::t('app', 'Level'),
            'title' => Yii::t('app', 'Title'),
            'subtitle' => Yii::t('app', 'Subtitle'),
            'style' => Yii::t('app', 'Style'),
            'fee' => Yii::t('app', 'Fee'),
            'introduce' => Yii::t('app', 'Introduce'),
            'tag' => Yii::t('app', 'Tag'),
            'keyword' => Yii::t('app', 'Keyword'),
            'ppt_word' => Yii::t('app', 'Ppt Word'),
            'author' => Yii::t('app', 'Author'),
            'origin_from' => Yii::t('app', 'Origin From'),
            'origin_url' => Yii::t('app', 'Origin Url'),
            'views' => Yii::t('app', 'Views'),
            'thumb' => Yii::t('app', 'Thumb'),
            'creator_name' => Yii::t('app', 'Creator Name'),
            'create_time' => Yii::t('app', 'Create Time'),
            'editor_name' => Yii::t('app', 'Editor Name'),
            'update_time' => Yii::t('app', 'Update Time'),
            'ip' => Yii::t('app', 'Ip'),
            'template' => Yii::t('app', 'Template'),
            'status' => Yii::t('app', 'Status'),
            'is_link' => Yii::t('app', 'Is Link'),
            'link_url' => Yii::t('app', 'Link Url'),
            'file_path' => Yii::t('app', 'File Path'),
            'note' => Yii::t('app', 'Note'),
        ];
    }
}
