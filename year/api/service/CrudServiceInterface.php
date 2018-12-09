<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/12/9
 * Time: 12:34
 */

namespace year\api\service;


use yii\base\Model;
use yii\data\ActiveDataProvider;

interface CrudServiceInterface
{
    /**
     * Lists all  models.
     * @param Model $searchModel
     * @param string $sort
     * @param int $page
     * @param int $pageSize
     * @return mixed|ActiveDataProvider|array
     */
    public function query(   $searchModel , $sort = '-id', $page = 0 ,$pageSize=10) ;


    /**
     * Displays a single  model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function get($id) ;


    /**
     * Creates a new  model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function create(Model $model) ;


    /**
     * Updates an existing Album model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function update($id, Model $model ) ;


    /**
     * Deletes an existing  model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function delete($id) ;


}