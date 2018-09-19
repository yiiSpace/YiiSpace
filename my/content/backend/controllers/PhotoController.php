<?php

namespace my\content\backend\controllers;

use Yii ;
use dmstr\bootstrap\Tabs;
use my\content\common\models\Photo;
use my\content\common\models\PhotoSearch;
use yii\helpers\Url;
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
        $searchModel  = new PhotoSearch;
        $dataProvider = $searchModel->search($_GET);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        // ## 处理传递相册id
        $query = $dataProvider->query;
        $albumId = Yii::$app->request->get('album_id', false);
        if ($albumId !== false) {
            $query->andFilterWhere([
                'album_id' => $albumId,
            ]);
            $searchModel->album_id = $albumId;
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    /**
     * Creates a new Photo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($album_id=0)
    {
        $model = new Photo();
        $model->album_id = $album_id ;

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
       try{
           if ($model->load(Yii::$app->request->post()) ) {
               $model->uri = UploadedFile::getInstance($model, 'uri');
               if($model->validate()){
                   /**
                    * @var \year\upload\UploadStorageInterface $uploadStorage
                    */
                   $uploadStorage = \Yii::$app->get('uploadStorage');
                   if(!empty($model->uri)){

                       $model->size = $model->uri->size ;
                       $model->ext = $model->uri->getExtension() ;

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

           }
           // for copy action
           elseif (!\Yii::$app->request->isPost) {
               $model->load($_GET);
           }
       }  catch (\Exception $e) {
           $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
           $model->addError('_exception', $msg);
       }


        return $this->render('create', ['model' => $model]);
    }
}
