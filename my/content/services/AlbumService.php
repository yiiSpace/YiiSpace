<?php

namespace my\content\services;

use Yii;
use my\content\common\models\Album;
use my\content\common\models\AlbumSearch;
use year\api\base\Service;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AlbumService implements the CRUD actions for Album model.
 */
class AlbumService extends Service
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
        ];
    }

         /**
     * Lists all Album models.
     * @return mixed
     */
    public function query( AlbumSearch $searchModel , $sort = '-id', $page = 0 ,$pageSize=10)
    {

        $dataProvider = $searchModel->search([]);


        // 开启 多字段排序功能：  -id , name 表示以id为倒序 name为升序的排序
        $dataProvider->sort->enableMultiSort = true;
        $dataProvider->sort->params = ['sort' => $sort];
        $dataProvider->pagination->setPage($page);

        // $dataProvider->query->andFilterWhere(['like', '{{%user}}.name', $q]);

        return $dataProvider ;
    }

    /**
     * Displays a single Album model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function get($id)
    {
          return $this->findModel($id);

    }

    /**
     * Creates a new Album model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function create(Album $model)
    {

        $model->save();
        return $model ;
    }

    /**
     * Updates an existing Album model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function update($id, Album $model )
    {
        $oldModel = $this->findModel($id);

        $oldModel->load( $model->getAttributes(), '' );
        $oldModel->save();

        return $oldModel ; // TODO 重新加载下该模型 // return $this->findModel($id) ;
    }

    /**
     * Deletes an existing Album model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function delete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $model;
    }

    /**
     * Finds the Album model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Album the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Album::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
