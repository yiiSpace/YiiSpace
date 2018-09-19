<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-7-29
 * Time: 上午12:05
 */

namespace year\user\helpers;


use year\user\models\User;
use yii\base\InvalidParamException;
use yii\helpers\Url;

class UserHelper {

    /**
     * @return string
     */
    public static function genSalt()
    {
        return md5(time());
    }

    /**
     * @param null|\yii\base\View|\yii\web\View $view
     * @return string
     */
    public static function getAssetsBaseUrl($view=null)
    {
        static $assetBaseUrl ;
        if(empty($assetBaseUrl)){
            if(null === $view){
                $view = \Yii::$app->view ;
            }
            $asset = \year\user\UserAsset::register($view);
            $assetBaseUrl = $asset->baseUrl ;
        }
        return $assetBaseUrl ;
    }

    /**
     * @param User $user
     * @param null|\yii\base\View|\yii\web\View $view
     * @return string
     * @throws
     */
    public static function getIconUrl(User $user,$view=null)
    {
         if(empty($user->icon_url)){
            return static::getAssetsBaseUrl($view) . '/images/icon-5.gif' ;
         }else{
             // TODO will implement this feature later
             throw \yii\base\NotSupportedException('will implement this later !');
         }
    }

    /**
     * @param User $user
     * @throws \yii\base\InvalidParamException
     * @return string
     */
    public static function getSpaceUrl($user)
    {
        if(is_scalar($user)){
            return Url::to(['/user/space','u'=>$user]);
        }elseif($user instanceof User){
            return Url::to(['/user/space','u'=>$user->primaryKey]);
        }else{
            throw  new InvalidParamException('param user should be a userId  or User model object !');
        }


    }
} 