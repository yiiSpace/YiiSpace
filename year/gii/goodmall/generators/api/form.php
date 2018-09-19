<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator year\gii\goodmall\generators\api\Generator */

echo \yii\helpers\Html::errorSummary($generator) ;

/*
echo $form->field($generator, 'podPath');
echo $form->field($generator, 'interactorName');
echo $form->field($generator, 'modelClass');

echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'viewPath');
echo $form->field($generator, 'baseControllerClass');
echo $form->field($generator, 'indexWidgetType')->dropDownList([
    'grid' => 'GridView',
    'list' => 'ListView',
]);
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'enablePjax')->checkbox();
echo $form->field($generator, 'messageCategory');
*/

echo $form->field($generator, 'podId');

//print_R( $generator->templates) ;

echo $form->field($generator, 'controllerType');

echo $form->field($generator, 'interactorType');

echo $form->field($generator, 'modelType');

echo $form->field($generator, 'searchModelType');

// FIXME 如果不输入对应的表名  需要通过modelType 得到字段信息  这个可能需要调用go端的api才行
echo $form->field($generator, 'tableName');