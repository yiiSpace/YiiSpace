<?php
/**
 * User: yiqing
 * Date: 14-8-1
 * Time: 下午4:04
 */

namespace year\status\controllers;

use Yii ;
use year\status\models\Status;

/**
 * for user center ,manager the user status
 *
 * Class MyController
 * @package year\status\controllers
 */
class MyController extends Controller{

    public function actionIndex()
    {
        $model = new Status();
        // TODO 先用最简单的实现一个插入再说
        $model->type = 'update';

        $model->profile_id = \Yii::$app->user->getId() ;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
} 