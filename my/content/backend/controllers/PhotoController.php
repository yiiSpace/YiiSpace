<?php

namespace my\content\backend\controllers;

use Yii ;
use dmstr\bootstrap\Tabs;
use my\content\common\models\Photo;
use my\content\common\models\PhotoSearch;
use yii\helpers\Url;

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
    public function actionCreate()
    {
        $model = new Photo();

        if(Yii::$app->request->getIsPost()){
            print_r([
                $_FILES,
                $_POST ,
            ]);
            die(__LINE__);
        }

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
        return $this->render('create', ['model' => $model]);
    }
}
