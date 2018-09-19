<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\model\Generator */


use yii\gii\generators\model\Generator;

echo \yii\helpers\Html::errorSummary($generator) ;


$onSelection = <<<JS
            function(data) {
               $("input[name*='apiPath']").val(data) ;
               alert('路径选择成功啦:'+data) ;
            }
JS;

echo \year\gii\yunying\widgets\PathSelector::widget([
    'onSelection'=>$onSelection,
]);

echo $form->field($generator, 'apiPath');

echo $form->field($generator, 'tableName')->textInput(['table_prefix' => $generator->getTablePrefix()]);
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'db');
echo $form->field($generator, 'useTablePrefix')->checkbox();
