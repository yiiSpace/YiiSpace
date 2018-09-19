<?php

namespace my\admin\common\models;

use Yii;
use \my\admin\common\models\base\Admin as BaseAdmin;

/**
 * This is the model class for table "ys_admin".
 */
class Admin extends BaseAdmin implements \yii\web\IdentityInterface
{
    // public $id;
    // public $username;
    // public $password;
    public $authKey;
    public $accessToken;
    // public $salt;

    // private static $users = [
    //     '1' => [
    //         'id' => '1',
    //         'username' => 'admin',
    //         'password' => 'admin',
    //         'authKey' => 'test100key',
    //         'accessToken' => '100-token',
    //     ],
    //     '2' => [
    //         'id' => '1',
    //         'username' => 'demo',
    //         'password' => 'demo',
    //         'authKey' => 'test101key',
    //         'accessToken' => '101-token',
    //     ],
    // ];
    public function rules()
    {
        $rules = [
            [['name', 'group_id'], 'required'],
            [['group_id', 'last_time', 'is_del'], 'integer'],
            [['create_time'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 32],
            [['salt'], 'string', 'max' => 60],
            [['last_ip'], 'string', 'max' => 30],
            [['name'], 'unique'],
            [['group_id'], 'required']
        ];

        if ($this->getIsNewRecord()) {
            array_push($rules, [['password'], 'required']);
            // return $rules;
        }
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        // return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        return Admin::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // foreach (self::$users as $user) {
        //     if ($user['accessToken'] === $token) {
        //         return new static($user);
        //     }
        // }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {

        $user = self::findOne(['name' => $username]);
        // var_dump($user);exit;
        return $user;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }


    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
        // return null;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
        // return null;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === UserHelper::encrypting($password . $this->salt);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->is_del = empty($this->is_del) ? 0 : $this->is_del;
                $this->salt = UserHelper::genSalt();
                $this->password = UserHelper::encrypting($this->password . $this->salt);
            } else {
                $this->password = UserHelper::encrypting($this->password . $this->salt);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if ($this->name == 'admin') {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    public function getGroup()
    {
        return $this->hasOne(AdminGroup::className(), ['id' => 'group_id']);
    }
}