<?php

namespace backend\controllers;

use yii\web\Controller;
use Yii;
use backend\models\AdminMenu;
use backend\models\AdminMenuSearch;

use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Request;
use yii\web\Response;

// FIXME 禁用掉主题功能
 Yii::$app->view->theme = null ;
/**
 * AdminMenuController implements the CRUD actions for AdminMenu model.
 */
class AdminMenuController extends Controller
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
     * Lists all AdminMenu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminMenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);



        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all AdminMenu models. for EasyUi
     * @return mixed
     */
    public function actionGridData()
    {
        $searchModel = new AdminMenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageParam = 'page';
        $dataProvider->pagination->pageSizeParam = 'rows';

       Yii::$app->response->format = Response::FORMAT_JSON ;
       $rows = [];
        foreach($dataProvider->getModels() as $model){
            $rows[] = ArrayHelper::toArray($model);
        }
        return [
          'total'=>$dataProvider->getTotalCount(),
            'rows'=>$rows ,
            'csrf'=>(Yii::$app->request->getCsrfTokenFromHeader())
        ];
    }
    /**
     * Displays a single AdminMenu model.
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
     * Creates a new AdminMenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdminMenu();

        $request = Yii::$app->request ;

        if ($model->load(Yii::$app->request->post()) && $model->makeRoot()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            if($request->getIsAjax()){
                $formContent =  $this->renderAjax('_form',[
                    'model'=>$model ,
                ]);
                // post request !
                if($model->hasErrors()){
                    Yii::$app->response->format = Response::FORMAT_JSON ;
                    return [
                        'error'=>true,
                        'data'=>$formContent,
                    ];
                }else{
                    return $formContent ;
                }

            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

        }
    }

    /**
     * Updates an existing AdminMenu model.
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
     * Deletes an existing AdminMenu model.
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
     * Finds the AdminMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminMenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
