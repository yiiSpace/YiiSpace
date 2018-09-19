<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/27
 * Time: 23:11
 */

namespace api\base;

use Yii;
use yii\base\Arrayable;
use yii\base\Component;
use yii\base\Model;
use yii\data\DataProviderInterface;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Link;
use yii\web\Request;
use yii\web\Response;

class Serializer extends \yii\rest\Serializer {

    /**
     * 为了达到跟其他异常格式尽量一致的返回：
     *    {    "success":false,
     *         "data":{"name":"Bad Request",
     *                 "message":"",
     *                 "code":0,
     *                 "status":400,
     *                 "type":"yii\\web\\BadRequestHttpException"
     *    }}
     *
     * Serializes the validation errors in a model.
     * @param Model $model
     * @return array the array representation of the errors
     */
    protected function serializeModelErrors($model)
    {

//        $firstErrors = array_values($model->getFirstErrors()) ;
//        throw new DataValidationHttpException(reset($firstErrors)) ;

        // 在自定风格分返回中此状态码并没有被使用 相当于一个http错误码
        $this->response->setStatusCode(422, 'Data Validation Failed.');
        $result = [];
        $topMostErrorMessage = '' ;
        foreach ($model->getFirstErrors() as $name => $message) {
            $result[] = [
                'field' => $name,
                'message' => $message,
            ];
            if($topMostErrorMessage === ''){
                $topMostErrorMessage = $message ;
            }
        }

        return [
            'name'=>'ValidationFailed',
            // 只取第一个错误
            'message'=>$topMostErrorMessage,
            'code'=> 0,
            'status'=>422,
            // 'type'=>'',
            'type'=>__CLASS__,
            // 返回所有错误
            'errors'=>$result ,
        ];
    }
}