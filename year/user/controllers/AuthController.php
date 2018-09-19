<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-7-29
 * Time: 下午12:09
 */

namespace year\user\controllers;

use year\user\models\LoginForm;


class AuthController extends \year\user\controllers\Controller{

    /**
     * Displays the 'login' page.
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

} 