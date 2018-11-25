<?php

namespace my\content\backend\controllers;

use my\content\common\models\Album;
use Yii;
use dmstr\bootstrap\Tabs;
use my\content\common\models\Photo;
use my\content\common\models\PhotoSearch;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\UploadedFile;

/**
 * This is the class for controller "PhotoController".
 */
class PhotoController extends \my\content\backend\controllers\base\PhotoController
{


    /**
     * Lists all Photo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PhotoSearch;
        $dataProvider = $searchModel->search($_GET);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        // ## 处理传递相册id
        $query = $dataProvider->query;
        $albumId = Yii::$app->request->get('album_id', false);
        $album = null ;
        if ($albumId !== false) {
            $query->andFilterWhere([
                'album_id' => $albumId,
            ]);
            $searchModel->album_id = $albumId;


        }
        if($searchModel->album_id != 0){
            if (($album = Album::findOne($searchModel->album_id)) !== null) {
            } else {
                throw new HttpException(404, 'The requested page does not exist.');
            }
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'album'=>$album,
        ]);
    }

    /**
     * 用于在线编辑器的选择图片
     *
     * @return string
     * @throws HttpException
     */
    public function actionEditorSelection()
    {

        $searchModel = new PhotoSearch;
        $dataProvider = $searchModel->search($_GET);

        // ## 处理传递相册id
        $query = $dataProvider->query;
        $albumId = Yii::$app->request->get('album_id', false);
        $album = null ;
        if ($albumId !== false) {
            $query->andFilterWhere([
                'album_id' => $albumId,
            ]);
            $searchModel->album_id = $albumId;


        }
        if($searchModel->album_id != 0){
            if (($album = Album::findOne($searchModel->album_id)) !== null) {
            } else {
                throw new HttpException(404, 'The requested page does not exist.');
            }
        }

        return $this->renderAjax('selection/index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'album'=>$album,
        ]);
    }


    /**
     * Creates a new Photo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($album_id = 0)
    {
        $model = new Photo();
        $model->album_id = $album_id;

        /*
        if(Yii::$app->request->getIsPost()){
            print_r([
                $_FILES,
                $_POST ,
            ]);
            die(__LINE__);
        }
        */
        /*
         try {
             if ($model->load($_POST) && $model->save()) {
                 return $this->redirect(['view', 'id' => $model->id]);
             } elseif (!\Yii::$app->request->isPost) {
                 $model->load($_GET);
             }
         } catch (\Exception $e) {
             $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
             $model->addError('_exception', $msg);
         }
        */
        try {
            if ($model->load(Yii::$app->request->post())) {
                $model->uri = UploadedFile::getInstance($model, 'uri');
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
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        throw new \Exception(print_r($model->getErrors(), true));
                    }
                }

            } // for copy action
            elseif (!\Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            $model->addError('_exception', $msg);
        }


        return $this->render('create', ['model' => $model]);
    }

    /**
     * @param $id
     * @return array
     * @throws MethodNotAllowedHttpException
     * @throws \yii\web\HttpException
     */
    public function actionAsAlbumCover($id)
    {
        if (Yii::$app->request->isAjax) {

            // $data = Yii::$app->request->post();

            $model = $this->findModel($id) ;
            /** @var Album $album */
            $album = $model->album ;
            if(!empty($album)){
                $album->cover_uri = $model->uri ;
                $album->save(false);
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'error' => 0,
            ];
        } else {
            throw  new MethodNotAllowedHttpException('must be called from ajax request !');
        }
    }
}
