<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/7/17
 * Time: 16:06
 */

namespace year\api\helpers;


use yii\data\DataProviderInterface;
use yii\rest\Serializer;

class ResponseHelper {

    public static function serializeDataProvider(DataProviderInterface $dataProvider)
    {

    }

    /**
     * @return Serializer
     */
    public static function getSerializer()
    {
        $serializer = \Yii::createObject([
            'class'=>Serializer::className(),
        ]);
        return $serializer ;
    }
}