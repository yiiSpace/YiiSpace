<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/21
 * Time: 13:09
 */

namespace api\modules\v1\controllers;


use yii\rest\Controller;

/**
 * 攻略api
 *
 * Class GuideController
 * @package api\modules\v1\controllers
 */
class GuideController extends Controller
{

    /**
     * 攻略分类
     *
     * @return array
     */
    public function actionCategories()
    {
        return [

        ];
    }

    /**
     * 攻略列表
     *
     * @return array
     */
    public function actionIndex()
    {
        return [];
    }

    /**
     * 攻略详情
     *
     * @return array
     */
    public function actionDetail()
    {
        return [];

    }

    /**
     * 指定攻略的评论
     *
     * @return array
     */
    public function actionComments()
    {
        return  [

    ];
    }
}