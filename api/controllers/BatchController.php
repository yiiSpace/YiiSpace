<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/20
 * Time: 23:48
 */

namespace api\controllers;


use yii\web\Controller;

/**
 * 批量请求api
 *
 * Class BatchController
 * @package api\controllers
 */
class BatchController extends Controller{


    /**
     * 批量调用
     * <code>
     *    {
     *       "requests": [
     *       {
     *       "method": "POST",
     *       "path": "/1/classes/GameScore",
     *       "body": {
     *       "score": 1337,
     *        "playerName": "Sean Plott"
     *        }
     *        },
     *        {
     *       "method": "POST",
     *        "path": "/1/classes/GameScore",
     *        "body": {
     *        "score": 1338,
     *        "playerName": "ZeroCool"
     *        }
     *        }
     *        ]
     *        }
     *</code>
     * @see http://docs.bmob.cn/restful/developdoc/index.html?menukey=develop_doc&key=develop_restful#index_%E6%89%B9%E9%87%8F%E6%95%B0%E6%8D%AE%E6%93%8D%E4%BD%9C
     * @return array
     * ~~~
     *      {
     *       "requests": [
     *       {
     *       "method": "POST",
     *       "path": "/1/classes/GameScore",
     *       "body": {
     *       "score": 1337,
     *        "playerName": "Sean Plott"
     *        }
     *        },
     *        {
     *       "method": "POST",
     *        "path": "/1/classes/GameScore",
     *        "body": {
     *        "score": 1338,
     *        "playerName": "ZeroCool"
     *        }
     *        }
     *        ]
     *        }
     *
     * ~~~
     */
    public function actionRequests()
    {
        return [

        ];
    }

}