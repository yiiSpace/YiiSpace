<?php

namespace backend\controllers;


use common\models\User;
use year\db\DynamicActiveRecord;
use yii\base\InvalidArgumentException;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * fixme 在多主键情况下 action的参数明显不够用 以后有空需要让其兼容复合主键情况
 */
class DynamicController extends Controller
{
    /**
     * @var null|string
     */
    static $dbID = null ;

    /**
     * @var string
     */
    static $tableName  ;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        // FIXME  可以在beforAction中设置 db 和表名
        // DynamicActiveRecord::forTable();

        //        if ($this->modelClass === null) {
//            throw new InvalidConfigException('The "modelClass" property must be set.');
//        }

        // 这样限制这个类只能内部使用了
        if(empty(static::$dbID) || empty(static::$tableName)){
            throw new InvalidArgumentException(__METHOD__) ;
        }
        DynamicActiveRecord::setDbID(static::$dbID);
        DynamicActiveRecord::setTableName(static::$tableName);

        // "@backend/runtime/dynamic/views/{$dbId}/{$table}",
        $this->setViewPath(sprintf("@backend/runtime/dynamic/views/%s/%s",static::$dbID,static::$tableName)  );

    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     *  Lists  all  User  models.
     *
     * @return  string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            // 'query' => User::find(),
            'query' => DynamicActiveRecord::find(),
            /*
            'pagination'  =>  [
            'pageSize'  =>  50
            ],
            'sort'  =>  [
            'defaultOrder'  =>  [
            'id'  =>  SORT_DESC,
            ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     *  Displays  a  single  User  model.
     * @param int $id
     * @return  string
     * @throws  NotFoundHttpException  if  the  model  cannot  be  found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     *  Creates  a  new  DynamicActiveRecord  model.
     *  If  creation  is  successful,  the  browser  will  be  redirected  to  the  'view'  page.
     * @return  string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DynamicActiveRecord();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     *  Updates  an  existing  User  model.
     *  If  update  is  successful,  the  browser  will  be  redirected  to  the  'view'  page.
     * @param int $id
     * @return  string|\yii\web\Response
     * @throws  NotFoundHttpException  if  the  model  cannot  be  found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     *  Deletes  an  existing  User  model.
     *  If  deletion  is  successful,  the  browser  will  be  redirected  to  the  'index'  page.
     * @param int $id
     * @return  \yii\web\Response
     * @throws  NotFoundHttpException  if  the  model  cannot  be  found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     *  Finds  the  User  model  based  on  its  primary  key  value.
     *  If  the  model  is  not  found,  a  404  HTTP  exception  will  be  thrown.
     * @param int $id
     * @return  DynamicActiveRecord  the  loaded  model
     * @throws  NotFoundHttpException  if  the  model  cannot  be  found
     */
    protected function findModel($id)
    {
//        $pkName = DynamicActiveRecord::primaryKey() ;
//        if (($model = DynamicActiveRecord::findOne(['id' => $id])) !== null) {
        if (($model = DynamicActiveRecord::findOne( $id )) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The  requested  page  does  not  exist.');
    }
}