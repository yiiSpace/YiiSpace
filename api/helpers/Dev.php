<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/27
 * Time: 21:44
 */

namespace api\helpers;


use yii\data\ArrayDataProvider;

/**
 * 开发帮助类
 *
 * Class Dev
 * @package api\helpers
 */
class Dev {

    /**
     * @param array $rawArray
     * @return ArrayDataProvider
     */
    public static function fakeProvider($rawArray=[])
    {
        $adp = new ArrayDataProvider() ;
        $adp->allModels = $rawArray ;
        return $adp ;
    }
}