<?php

namespace year\status\models;

use Yii;
use yii\db\ActiveRecord ;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;


/**
 * This is the model class for table "tbl_status".
 *
 * @property string $id
 * @property string $content
 * @property string $type
 * @property integer $creator_id
 * @property integer $create_at
 * @property integer $profile_id
 * @property integer $approved
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%status}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['content', 'type', 'creator_id', 'create_at', 'profile_id'], 'required'],
            [['content', 'type', 'profile_id'], 'required'],
            [['approved'], 'default','value'=>1],
            [['content'], 'string'],
            [['creator_id', 'create_at', 'profile_id', 'approved'], 'integer'],
            [['type'], 'string', 'max' => 120]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('status', 'ID'),
            'content' => Yii::t('status', 'content'),
            'type' => Yii::t('status', 'type'),
            'creator_id' => Yii::t('status', 'creator_id'),
            'create_at' => Yii::t('status', 'create_at'),
            'profile_id' => Yii::t('status', 'profile'),
            'approved' => Yii::t('status', 'approved'),
        ];
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_at'],
                ],
                'createdAtAttribute' => 'create_at',
                // 'updatedAtAttribute' => 'update_time',
                // 'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['creator_id'],
                ],
                'createdByAttribute' => 'creator_id',
                //  'updatedByAttribute' => 'updater_id',
            ],


        ];
    }
}
