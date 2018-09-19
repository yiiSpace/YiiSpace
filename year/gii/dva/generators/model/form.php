<?php

use schmunk42\giiant\generators\model\Generator;
use schmunk42\giiant\helpers\SaveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator \year\gii\dva\generators\model\Generator */

/*
 * JS for listbox "Saved Form"
 * on chenging listbox, form fill with selected saved forma data
 * currently work with input text, input checkbox and select form fields
 */
$this->registerJs(SaveForm::getSavedFormsJs($generator->getName()), yii\web\View::POS_END);
$this->registerJs(SaveForm::jsFillForm(), yii\web\View::POS_END);



echo $form->field($generator, 'srcDir');

echo $form->field($generator, 'podName');

echo $form->field($generator, 'ns');

echo $form->field($generator, 'apiEndpoint');

echo $form->field($generator, 'tableName');
echo $form->field($generator, 'tablePrefix');
echo $form->field($generator, 'modelClass');

echo $form->field($generator, 'baseClass');
echo $form->field($generator, 'db');



?>

