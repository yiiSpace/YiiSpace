<?php

namespace backend\controllers;

use Yii;
use common\models\Migration;
use common\models\MigrationSearch;
use backend\components\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\Request;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/*
if(\Yii::$app->request->getIsAjax()){
    // 禁用ajax 模式下禁用某些js的渲染！前提是 前面的几次请求中请求了！ 此段代码应该放在基类 或者某个合适地方！
    //  \Yii::$container->set('yii\web\JqueryAsset', ['js' => []]);
}
*/

/**
 * MigrationController implements the CRUD actions for Migration model.
 */
class MigrationController extends Controller
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
     * Lists all Migration models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MigrationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

/**
*@see https://github.com/samdark/yii2-cookbook/blob/master/book/response-formats.md
*
* Lists all Migration models. for EasyUi
* @return mixed
*/
public function actionGridData()
{
    $searchModel = new MigrationSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    $dataProvider->pagination->pageParam = 'page';
    $dataProvider->pagination->pageSizeParam = 'rows';

    // 排序功能集成
    $dataProvider->setSort([
    'class' => \year\easyui\Sort::className(),
    //        'attributes'=>[
    //            'username',
    //        ]
    ]);
    $dataProvider->getSort()->enableMultiSort = true;

    /**
     * ===========================================================================================\
     */
    if(Yii::$app->request->getIsPost()){
        // 这里测试excel导出 此处列名可以来自UI传递 由用户控制导出那些列 export_cols = " col1,col2,col3.... ";

        $gridColumns = [
                'version',
            'apply_time',
        ];
        // 模拟数据
        $_POST['exportFull'] = true;
        $_POST[ExportMenu::PARAM_EXPORT_TYPE] = ExportMenu::FORMAT_EXCEL;
        $_POST[ExportMenu::PARAM_COLSEL_FLAG] = false;  //  控制是否允许选择性导出
        $_POST[ExportMenu::PARAM_EXPORT_COLS] = implode(',',$gridColumns);

        // Renders a export dropdown menu
        echo \kartik\export\ExportMenu::widget([
            // 'enablePagination'=>true , // 开启分页
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns
        ]);
    }
    /**
     * ===========================================================================================/
     */

    Yii::$app->response->format = Response::FORMAT_JSON ;
    $rows = [];
    foreach($dataProvider->getModels() as $model){
          $rows[] = ArrayHelper::toArray($model);
    }
    return [
        'total'=>$dataProvider->getTotalCount(),
        'rows'=>$rows ,
         'url'=>\Yii::$app->request->getUrl(),
    ];
}

    /**
     * Displays a single Migration model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Migration model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Migration();

        $request = Yii::$app->request ;

        if ($model->load($request->post()) && $model->save()) {

            if($request->getIsAjax()){
                Yii::$app->response->format = Response::FORMAT_JSON ;
                return [
                    'status'=>'success',
                    'msg'=>'创建成功！',
                ];
            }else{
                return $this->redirect(['view', 'id' => $model->version]);
            }

        } else {

            if($request->getIsAjax()){
                $formContent =  $this->renderAjax('_form',[
                    'model'=>$model ,
                ]);
            // post request !
                if($model->hasErrors()){
                    Yii::$app->response->format = Response::FORMAT_JSON ;
                    return [
                        'status'=>'error',
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
     * Updates an existing Migration model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $request = Yii::$app->request ;
        if ($model->load($request->post()) && $model->save()) {
            if($request->getIsAjax()){
                Yii::$app->response->format = Response::FORMAT_JSON ;
                return [
                    'status'=>'success',
                    'msg'=>'修改成功！',
                ];
            }else{
                 return $this->redirect(['view', 'id' => $model->version]);
            }
        } else {
           if($request->getIsAjax()){
                $formContent =  $this->renderAjax('_form',[
                     'model'=>$model ,
                ]);
              // post request !
                if($model->hasErrors()){
                    Yii::$app->response->format = Response::FORMAT_JSON ;
                    return [
                        'status'=>'error',
                        'data'=>$formContent,
                    ];
                }else{
                    return $formContent ;
                }
            }else{
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Deletes an existing Migration model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        $request = Yii::$app->request ;
        if($request->getIsAjax()){
                Yii::$app->response->format = Response::FORMAT_JSON ;
                return [
                    'status'=>'success',
                    'msg'=> '删除成功！',
                ];
        }else{
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Migration model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Migration the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Migration::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
