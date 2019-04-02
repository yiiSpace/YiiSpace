<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/4/1
 * Time: 19:55
 */

namespace my\test\frontend\controllers;


use my\test\common\models\UploadForm;
use yii\web\Controller;
use yii\web\UploadedFile;

class UploadController extends Controller
{

    public function actionIndex()
    {
        $model = new UploadForm();

        if (\Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            /*
            if ($model->upload()) {
                // file is uploaded successfully
                return;
            }
            */
            if ($model->validate()) {
                die("success");
            }
        }

        return $this->render('index', [
            'model' => $model
        ]);

    }

}