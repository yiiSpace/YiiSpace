<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model my\devtools\common\models\ApiProvider */
/* @var $form ActiveForm */
?>

<?php
$tableSchema = \my\devtools\common\models\ApiProvider::getTableSchema($model->tableName);

$requiredParams = $optionalParams = [];
foreach ($tableSchema->columns as $column){
    echo $column->name ;
    if($column->allowNull || !empty($column->defaultValue)){
        $optionalParams[$column->name] = empty($column->defaultValue)?
            \my\devtools\common\models\ApiProvider::getPhpTypeZeroValue($column->phpType):
            $column->defaultValue
        ;
    }   else{
        $requiredParams[$column->name] = $column->name;
    }
}
/*
print_r([
   $requiredParams,
    $optionalParams,
])
*/;
?>

<code>
    /**
    * TODO 这里要根据情况修改下相关代码段
    * <?= $model->getModelName() ?>列表
    *
    * @param string $q
    * @param int $page
    * @param string $sort -views,name  按照浏览量降序，name升序
    * @param string $filter 过滤条件 如 'store_type=2&car_type=3'
    * @return ActiveDataProvider
    */
    public function actionList(
          $q = '', $filter = '', $sort = '-views', $page = 0
    )
    {
    $requestParams = [] ;
    if (is_string($filter)) {
           $requestParams = Request::parseStr($filter);
    } elseIf (is_array($filter)) {
          $requestParams = $filter;
    }


    $searchModel = new <?= $model->getModelName() ?>Search();
    // TODO 务必修改gii生成的search方法
    /**
    *    public function search($params,$formName=null)
        {
            $query = Guide::find();

            $dataProvider = new ActiveDataProvider([
            'query' => $query,
            ]);

            $this->load($params,$formName);
    */
    $dataProvider = $searchModel->search($requestParams, '');
    // 开启 多字段排序功能：  -id , name 表示以id为倒序 name为升序的排序
    $dataProvider->sort->enableMultiSort = true;
    $dataProvider->sort->params = ['sort' => $sort];
    $dataProvider->pagination->setPage($page);

    $query = $dataProvider->query;
    if (! empty($q)) {

        //   $tableName =  $searchModel->tableName(); // <?= $model->tableName . PHP_EOL ?>
        //   $query->andFilterWhere(['like', "{$tableName}.name", $q]);
       $query->andFilterWhere(['like', 'name', $q]);
    }

    return $dataProvider;

    }

</code>
