<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/8/18
 * Time: 22:41
 */

namespace year\web;

use Yii ;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * used to perform the ajax validation . same as yii1
 *
 * Class AjaxValidationTrait
 * @package year\web
 */
trait AjaxValidationTrait
{

    /**
     * Performs AJAX validation.
     *
     * @param array|Model $model
     *
     * @throws ExitException
     */
    protected function performAjaxValidation($model)
    {
        if (Yii::$app->request->getIsAjax() && !Yii::$app->request->getIsPjax()) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                echo json_encode(ActiveForm::validate($model));
                Yii::$app->end();
            }
        }
    }
}