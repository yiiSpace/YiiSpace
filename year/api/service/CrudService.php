<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/12/9
 * Time: 11:50
 */

namespace year\api\service;


use yii\base\BaseObject;
use yii\base\Model;
use yii\data\ActiveDataProvider;

abstract  class CrudService    extends BaseObject     implements CrudServiceInterface

{

    /**
     * @var string the model class name. This property must be set.
     */
    public $modelClass;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->modelClass === null) {
            throw new InvalidConfigException('The "modelClass" property must be set.');
        }
    }

    /**
     * Lists all  models.
     * @param Model $searchModel
     * @param string $sort
     * @param int $page
     * @param int $pageSize
     * @return mixed|ActiveDataProvider|array
     */
    public function query( $searchModel, $sort = '-id', $page = 0, $pageSize = 10)
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
     * Displays a single  model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function get($id)
    {
        return $this->findModel($id);
    }

    /**
     * Creates a new  model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function create(Model $model)
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
    public function update($id, Model $model)
    {
        // TODO: Implement update() method.
    }

    /**
     * Deletes an existing  model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}