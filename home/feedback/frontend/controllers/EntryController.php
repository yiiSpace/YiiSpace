<?php

namespace home\feedback\frontend\controllers;

use year\captcha\gregwar\CaptchaAction;
use Yii;
use home\feedback\common\models\Feedback;
use home\feedback\common\models\FeedbackSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EntryController implements the CRUD actions for Feedback model.
 */
class EntryController extends Controller
{
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

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                // 'class' =>  CaptchaAction::className() ,
                // 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength'=>4,
                'minLength'=>4,
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
        // added at 2016/9/18
        $query->andWhere([
           '<>','type_id',Feedback::TYPE_TO_DIRECTOR,
        ]);

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
     * Creates a new Feedback model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function action2director()
    {
        $model = new Feedback();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('2director', [
                'model' => $model,
            ]);
        }
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
