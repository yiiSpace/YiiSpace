<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$serviceClass = StringHelper::basename($generator->serviceClass);
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

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->serviceClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseServiceClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * <?= $serviceClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $serviceClass ?> extends <?= StringHelper::basename($generator->baseServiceClass) . "\n" ?>
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
        ];
    }

     <?php
     $queryArgSearchModel = '' ;
     if (!empty($generator->searchModelClass)){
         $queryArgSearchModel =  (isset($searchModelAlias) ? $searchModelAlias : $searchModelClass)  ;
         $queryArgSearchModel .= ' $searchModel ,' ;
     }
     ?>
    /**
     * Lists all <?= $modelClass ?> models.
     * @return mixed
     */
    public function query( <?= $queryArgSearchModel ?> $sort = '-id', $page = 0 ,$pageSize=10)
    {
<?php if (!empty($generator->searchModelClass)): ?>

        $dataProvider = $searchModel->search([]);

<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);
<?php endif; ?>

        // 开启 多字段排序功能：  -id , name 表示以id为倒序 name为升序的排序
        $dataProvider->sort->enableMultiSort = true;
        $dataProvider->sort->params = ['sort' => $sort];
        $dataProvider->pagination->setPage($page);

        // $dataProvider->query->andFilterWhere(['like', '{{%user}}.name', $q]);

        return $dataProvider ;
    }

    /**
     * Displays a single <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function get(<?= $actionParams ?>)
    {
          return $this->findModel(<?= $actionParams ?>);

    }

    /**
     * Creates a new <?= $modelClass ?> model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function create(<?= $modelClass ?> $model)
    {

        $model->save();
        return $model ;
    }

    /**
     * Updates an existing <?= $modelClass ?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function update(<?= $actionParams ?>, <?= $modelClass ?> $model )
    {
        $oldModel = $this->findModel(<?= $actionParams ?>);

        $oldModel->load( $model->getAttributes(), '' );
        $oldModel->save();

        return $oldModel ; // TODO 重新加载下该模型 // return $this->findModel(<?= $actionParams ?>) ;
    }

    /**
     * Deletes an existing <?= $modelClass ?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function delete(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);
        $model->delete();

        return $model;
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
        }

        throw new NotFoundHttpException(<?= $generator->generateString('The requested page does not exist.') ?>);
    }
}
