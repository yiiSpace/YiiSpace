<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

$tableSchema = $generator->getTableSchema();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\Request;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;

/*
if(\Yii::$app->request->getIsAjax()){
    // 禁用ajax 模式下禁用某些js的渲染！前提是 前面的几次请求中请求了！ 此段代码应该放在基类 或者某个合适地方！
    //  \Yii::$container->set('yii\web\JqueryAsset', ['js' => []]);
}
*/

/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
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
     * Lists all <?= $modelClass ?> models.
     * @return mixed
     */
    public function actionIndex()
    {
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }

/**
*@see https://github.com/samdark/yii2-cookbook/blob/master/book/response-formats.md
*
* Lists all <?= $modelClass ?> models. for EasyUi
* @return mixed
*/
public function actionGridData()
{
<?php if (!empty($generator->searchModelClass)): ?>
    $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
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
    <?php
    foreach ($tableSchema->columns as $column) {
        echo "            '" . $column->name . "',\n";
    }
    ?>
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
<?php else: ?>
    $dataProvider = new ActiveDataProvider([
         'query' => <?= $modelClass ?>::find(),
    ]);

    $dataProvider->pagination->pageParam = 'page';
    $dataProvider->pagination->pageSizeParam = 'rows';

    // 排序功能集成
    $dataProvider->setSort([
    'class'=>year\easyui\Sort::className(),
        //        'attributes'=>[
        //            'username',
        //        ]
    ]);
    // 允许多重排序！
    $dataProvider->getSort()->enableMultiSort = true ;

    /**
     * ===========================================================================================\
     */
    if(Yii::$app->request->getIsPost()){
        // 这里测试excel导出 此处列名可以来自UI传递 由用户控制导出那些列 export_cols = " col1,col2,col3.... ";

        $gridColumns = [
    <?php
    foreach ($tableSchema->columns as $column) {
        echo "            '" . $column->name . "',\n";
    }
    ?>
        ];
    // 模拟数据
    $_POST['exportFull'] = true;
    $_POST[ExportMenu::PARAM_EXPORT_TYPE] = ExportMenu::FORMAT_EXCEL;
    $_POST[ExportMenu::PARAM_COLSEL_FLAG] = false;  //  控制是否允许选择性导出（指定需要导出的列）
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
<?php endif; ?>
}

    /**
     * Displays a single <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionView(<?= $actionParams ?>)
    {
        return $this->render('view', [
            'model' => $this->findModel(<?= $actionParams ?>),
        ]);
    }

    /**
     * Creates a new <?= $modelClass ?> model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new <?= $modelClass ?>();

        $request = Yii::$app->request ;

        if ($model->load($request->post()) && $model->save()) {

            if($request->getIsAjax()){
                Yii::$app->response->format = Response::FORMAT_JSON ;
                return [
                    'status'=>'success',
                    'msg'=>'创建成功！',
                ];
            }else{
                return $this->redirect(['view', <?= $urlParams ?>]);
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
     * Updates an existing <?= $modelClass ?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionUpdate(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);

        $request = Yii::$app->request ;
        if ($model->load($request->post()) && $model->save()) {
            if($request->getIsAjax()){
                Yii::$app->response->format = Response::FORMAT_JSON ;
                return [
                    'status'=>'success',
                    'msg'=>'修改成功！',
                ];
            }else{
                 return $this->redirect(['view', <?= $urlParams ?>]);
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
     * Deletes an existing <?= $modelClass ?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionDelete(<?= $actionParams ?>)
    {
        $this->findModel(<?= $actionParams ?>)->delete();

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
     * Finds the <?= $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?=                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?= $actionParams ?>)
    {
<?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
        if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
