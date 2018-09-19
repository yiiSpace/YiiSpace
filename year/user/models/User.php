<?php

namespace year\user\models;

use Yii;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "tbl_user".
 *
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $icon_url
 * @property string $password
 * @property string $salt
 * @property integer $status
 * @property string $last_login_ip
 * @property integer $last_active_at
 * @property integer $created_at
 */
class User extends \yii\db\ActiveRecord  implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'salt', 'created_at'], 'required'],
            [['status', 'last_active_at', 'created_at'], 'integer'],
            [['username', 'email', 'icon_url', 'password', 'salt'], 'string', 'max' => 255],
            [['last_login_ip'], 'string', 'max' => 50],
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
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'icon_url' => Yii::t('app', 'Icon Url'),
            'password' => Yii::t('app', 'Password'),
            'salt' => Yii::t('app', 'Salt'),
            'status' => Yii::t('app', 'Status'),
            'last_login_ip' => Yii::t('app', 'Last Login Ip'),
            'last_active_at' => Yii::t('app', 'Last Active At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    //------------------------------------------------------------------------------------------------------------\\
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Finds user by username or email
     *
     * @param string $userStr
     * @return static|null
     */
    public static function findByUserOrEmail($userStr)
    {
        return static::find()->andWhere(['username' => $userStr])->orWhere(['email' => $userStr])->one();
    }

    /**
     * Finds user by password reset key
     * TODO  not used yet !!!
     * @param string $key password reset key
     * @param integer $expire password reset key expiry
     * @return static|null
     */
    public static function findByPasswordResetKey($key, $expire)
    {
        if (static::isKeyExpired($key, $expire)) {
            return null;
        }

        return static::find(['reset_key' => $key])->active();
    }

    //------------------------------------------------------------------------------------------------------------//

    //------------------------------------------------------------------------------------------------------------\\
    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
        throw new NotSupportedException(sprintf('"%s" is not implemented.',__METHOD__));
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->primaryKey ;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // throw new NotSupportedException(sprintf('"%s" is not implemented.',__METHOD__));
        return md5($this->primaryKey);
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // throw new NotSupportedException(sprintf('"%s" is not implemented.',__METHOD__));
        return $authKey == md5($this->primaryKey);
    }
    //------------------------------------------------------------------------------------------------------------//

}
