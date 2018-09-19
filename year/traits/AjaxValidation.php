<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/20
 * Time: 22:47
 */

namespace year\traits;

use yii\base\Model;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * yii1种的方法迁移 存在的问题：
 * - 可以移到year/web 名字空间去 直接用year/traits 有点不舒服
 * - ajax验证还有另外的用法 在控制器中：
 *   ```
 *       if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
            }
            if ($model->validate()) {

                 }
        }
 * -  两种方法有差异 上面这种方法 yii的执行流程时完备的。用传统方法 有些流程恐怕走不完 由于内部直接Yii::$app->end()
 *    可能存在的问题是有些方法点可能就不执行了！比如afterXxx 之类的！也就是说 对于完整的执行流 这种方法可能比较武断--霸道！
 *
 * Class AjaxValidation
 * @package year\traits
 */
trait AjaxValidation {

    /**
     * TODO should support multiple models !
     *
     *  public function actionLogin()
        {
            $model = \Yii::createObject(LoginForm::className());

            $this->performAjaxValidation($model);

            if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
                  return $this->goBack();
            }

            return $this->render('login', [
                 'model'  => $model,
                  'module' => $this->module,
            ]);
        }
     *
     * Performs ajax validation.
     * @param Model $model
     * @throws \yii\base\ExitException
     */
    protected function performAjaxValidation( $model)
    {
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            echo json_encode(ActiveForm::validate($model));
            \Yii::$app->end();
        }

    }
}