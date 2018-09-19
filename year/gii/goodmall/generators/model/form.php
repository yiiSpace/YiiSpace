<?php

use schmunk42\giiant\generators\model\Generator;
use schmunk42\giiant\helpers\SaveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator \year\gii\goodmall\generators\model\Generator */

/*
 * JS for listbox "Saved Form"
 * on chenging listbox, form fill with selected saved forma data
 * currently work with input text, input checkbox and select form fields
 */
$this->registerJs(SaveForm::getSavedFormsJs($generator->getName()), yii\web\View::POS_END);
$this->registerJs(SaveForm::jsFillForm(), yii\web\View::POS_END);



echo $form->field($generator, 'srcDir');

echo $form->field($generator, 'tableName');
echo $form->field($generator, 'tablePrefix');
echo $form->field($generator, 'modelClass');

echo $form->field($generator, 'generateSearchModel')->checkbox();


echo $form->field($generator, 'db');



?>

