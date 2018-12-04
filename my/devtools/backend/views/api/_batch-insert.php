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

批量插入 片段：
<code>
    <?php  $batchItemVar = '$'.lcfirst($model->getModelName()).'Data'; ?>
    <?=  $batchItemVar ?> = [] ;
    for($i = 0; $i < 10 ; $i++){
            <?= $batchItemVar ?>[] = [

    <?php
    $tableColumnNames =  [] ;
    foreach ($tableSchema->columns as $column):
        $tableColumnNames[] =  $column->name ;
        ?>
       <?= " \${$column->name} ,\n" ?>
    <?php endforeach; ?>

            ];
    }

    // 批量插入表<?= $model->tableName ?>
    Yii::$app->db
    ->createCommand()
    ->batchInsert(
    <?= $model->getModelName() ?>::tableName(),
         [<?= implode(',',$tableColumnNames) . (count($tableColumnNames)>0?',':'') ?>],
         <?= $batchItemVar ?>
    )->execute();

</code>
