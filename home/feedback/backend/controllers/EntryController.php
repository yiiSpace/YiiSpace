<?php

namespace home\feedback\backend\controllers;

use porcelanosa\yii2togglecolumn\ToggleAction;
use Yii;
use home\feedback\common\models\Feedback;
use home\feedback\common\models\FeedbackSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii2mod\editable\EditableAction;

/**
 * EntryController implements the CRUD actions for Feedback model.
 */
class EntryController extends Controller
{
    // public $layout = '//main' ;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'toggle' => [
                'class' => ToggleAction::className(),
                'modelClass' => Feedback::className(),
                // Uncomment to enable flash messages
                //'setFlash' => true,
                'attribute' => 'hot_grade',
                'primaryKey' => 'id'
            ],
        ];
    }

    /**
     * Lists all Feedback models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $query = $dataProvider->query;

        if (!empty($searchModel->date_from)) {
            $dateFrom = strtotime($searchModel->date_from);
            $dateTo = strtotime($searchModel->date_to);


            if ($dateFrom == $dateTo) {
                $query->andFilterWhere(
                    ['>=', 'created_at', $dateFrom]
                );
            } else {
                /*
                $query->andFilterWhere(
                    ['>=', 'created_at', $dateFrom]
                );
                $query->andFilterWhere(
                    ['<=', 'created_at', $dateTo]
                );
                */
                $query->andFilterWhere(
                    ['between', 'created_at', $dateFrom, $dateTo]
                );
            }
        }

        $dataProvider->sort->defaultOrder = [
            //  'name' => SORT_ASC,
            'created_at' => SORT_DESC,
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Feedback model.
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
     * Creates a new Feedback model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Feedback();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Feedback model.
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
     * Deletes an existing Feedback model.
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
     * Finds the Feedback model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Feedback the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feedback::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
