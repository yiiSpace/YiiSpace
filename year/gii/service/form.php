<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator \year\gii\service\Generator */

echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'serviceClass');

echo $form->field($generator, 'baseServiceClass');

echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');
