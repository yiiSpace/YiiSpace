<?php

namespace my\test\common\models\base;

use Yii;

/**
 * This is the base-model class for table "msg".
 *
 * @property string $id
 * @property string $type
 * @property integer $uid
 * @property string $data
 * @property integer $snd_type
 * @property integer $snd_status
 * @property integer $priority
 * @property integer $to_id
 * @property string $msg_pid
 * @property integer $create_time
 * @property integer $sent_time
 * @property integer $delete_time
 */
class Msg extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'data', 'create_time'], 'required'],
            [['uid', 'snd_type', 'snd_status', 'priority', 'to_id', 'msg_pid', 'create_time', 'sent_time', 'delete_time'], 'integer'],
            [['data'], 'string'],
            [['type'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'uid' => 'Uid',
            'data' => 'Data',
            'snd_type' => 'Snd Type',
            'snd_status' => 'Snd Status',
            'priority' => 'Priority',
            'to_id' => 'To ID',
            'msg_pid' => 'Msg Pid',
            'create_time' => 'Create Time',
            'sent_time' => 'Sent Time',
            'delete_time' => 'Delete Time',
        ];
    }


    
}
