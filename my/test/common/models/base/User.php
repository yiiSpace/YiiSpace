<?php

namespace my\test\common\models\base;

use Yii;

/**
 * This is the base-model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $icon_uri
 * @property string $email
 * @property string $activkey
 * @property integer $superuser
 * @property integer $status
 * @property string $create_at
 * @property string $lastvisit_at
 *
 * @property \my\test\common\models\UserProfile $userProfile
 */
class User extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['superuser', 'status'], 'integer'],
            [['create_at', 'lastvisit_at'], 'safe'],
            [['username'], 'string', 'max' => 20],
            [['password', 'email', 'activkey'], 'string', 'max' => 128],
            [['icon_uri'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'icon_uri' => 'Icon Uri',
            'email' => 'Email',
            'activkey' => 'Activkey',
            'superuser' => 'Superuser',
            'status' => 'Status',
            'create_at' => 'Create At',
            'lastvisit_at' => 'Lastvisit At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(\my\test\common\models\UserProfile::className(), ['user_id' => 'id']);
    }


    
}
