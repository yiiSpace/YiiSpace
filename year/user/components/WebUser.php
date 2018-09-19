<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-7-29
 * Time: 下午1:25
 */

namespace year\user\components;


use Yii;


class WebUser extends \yii\web\User
{
    /**
     * @var boolean whether to enable cookie-based login. Defaults to true.
     */
    public $enableAutoLogin = true;

    /**
     * @var string|array the URL for login when [[loginRequired()]] is called.
     */
    public $loginUrl = ['/user/auth/login'];

    /**
     * Initializes the User component
     */
    public function init()
    {
        if (null === $this->identityClass) {
            $this->identityClass = 'year\user\models\User';
        }
        parent::init();
    }
}