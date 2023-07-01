<?php

namespace common\components;

use Yii ;
use yii\web\Response;
use yii\base\Event ;

/**
 * @see https://blog.csdn.net/bl724/article/details/115877037?spm=1001.2014.3001.5502
 * 
 * response'=>[
 *      'class'=> '....\ApiResponse',
 *      'on beforeSend'=> ApiResponse::handleBeforeSend
 * ] 
 */
class ApiResponse extends Response
{



    /**
     * Undocumented function
     *
     * @param Event|null $event the event instance. If not set, a default [[Event]] object will be created.
     * @return void
     */
    public static function handleBeforeSend($event)
    {
        /** @var Static */
       $response = $event->sender ;
       $code = $response->statusCode ;

       $data = [
        'code'=>$code == 200 ? 0: -1 ,
        'status'=> $code ,
       ];
       $data['msg'] = $code >= 400 ? Yii::$app->getErrorHandler()->exception->getMessage(): 'OK';

       if ($code == 200){
         $data['data'] = $response->data ;
       }

       $response->data = $data ;
       $response->statusCode = 200 ;
       $response->format = static::FORMAT_JSON ;
        
    }
}