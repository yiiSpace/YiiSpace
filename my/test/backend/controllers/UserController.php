<?php

namespace my\test\backend\controllers;

use Yii;
use my\test\common\models\User;
use my\test\common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\base\Model;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

//--------------------------------------------------------------------------------------------------------\\
/**
* 批量更新操作
*
* @return string|\yii\web\Response
*/
public function actionBatchUpdate()
{
        // retrieve items to be updated in a batch mode
        // assuming each item is of model class 'Item'
        $items = $this->getItemsToUpdate();

        if (empty($items)) {
              Yii::$app->session->setFlash('error', "select nothing! .");
              return $this->redirect(['index']); // redirect to your next desired page
        }

        if (Model::loadMultiple($items, Yii::$app->request->post()) &&
             Model::validateMultiple($items)
        ) {
                $count = 0;
                foreach ($items as $item) {
                    // populate and save records for each model
                    if ($item->save()) {
                    // do something here after saving
                    $count++;
                   }
                }
            Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
            return $this->redirect(['index']); // redirect to your next desired page
        } else {
            return $this->render('batch-update', [
            'items' => $items,
            ]);
        }
}

/**
* 获取需要批量更新的模型数组
*
* @return array|\yii\db\ActiveRecord[]|\my\test\common\models\User[]
*/
public function getItemsToUpdate()
{
        $request = Yii::$app->request;
        $selectionIds = $request->post('selection', []);
        $items = User::find()
        ->where(['id' => $selectionIds])
        // FIXME 务必使之有序！！！
        // ->orderBy('id DESC')
        ->indexBy('id')
        ->all();
        return $items;
}
//--------------------------------------------------------------------------------------------------------//

}
