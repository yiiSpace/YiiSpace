<?php

namespace my\content\backend\controllers;

use my\content\common\models\Photo;
use year\api\base\ValidationException;
use yii\web\Controller;
use yii\web\UploadedFile;
use Yii;

/**
 * Default controller for the `content` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * todo: 实现自己的 根据：  vova07\imperavi\actions|UploadFileAction
     *
     * @param int $album_id
     * @return \yii\web\Response
     */
    public function actionImageUpload($album_id = 0)
    {
        $request = Yii::$app->request ;

        $album = $request->post('album');

        if( empty($album)  ){
            return $this->asJson([
                'error' => true ,
                'message' => '请选择一个相册先...'
            ]);
        }

        $model = new Photo();
        $model->album_id = $album;

        $result = [] ;
        try {
            if ($model->load(Yii::$app->request->post() ,'')) {
                // $model->uri = UploadedFile::getInstance($model, 'uri');
                $model->uri = UploadedFile::getInstanceByName( 'file');
                if ($model->validate()) {
                    /**
                     * @var \year\upload\UploadStorageInterface $uploadStorage
                     */
                    $uploadStorage = \Yii::$app->get('uploadStorage');
                    if (!empty($model->uri)) {

                        $model->size = $model->uri->size;
                        $model->ext = $model->uri->getExtension();

                        $model->uri = $uploadStorage->performUpload($model->uri);
                    }
                    // 跳过验证
                    if ($model->save(false)) {

                        $imgUrl = $uploadStorage->getPublicUrl($model->uri);
                      //  return $this->redirect(['view', 'id' => $model->id]);
                        $result = [
                            'filelink'=>$imgUrl ,
                            'id' => $model->id,
                        ] ;
                    } else {
                        // throw new \Exception(print_r($model->getErrors(), true));
                        return $this->asJson([
                            'error' => true ,
                            'message' => print_r($model->getErrors(), true),
                        ]);
                    }
                }else{
                    return $this->asJson([
                        'error' => true ,
                        'message' => print_r($model->getErrors(), true),
                    ]);
                }

            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            // $model->addError('_exception', $msg);
            return $this->asJson([
                'error' => true ,
                'message' => $msg,
            ]);
        }

        // @see https://imperavi.com/redactor/docs/settings/image/#s-imageupload
        /**
         * 这个docs  有问题！
         */

        // throw  new ValidationException('必须选择相册哦！');
        return $this->asJson(
            $result
        );
    }
}
