<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/7/17
 * Time: 13:55
 */

namespace year\api\helpers;


use yii\rest\Serializer;

class Request {

    public static function parseStr($queryStr='')
    {
        $requestParams = [] ;
        if(!empty($queryStr)){
            parse_str($queryStr , $requestParams) ;
        }
        return $requestParams ;
    }


}