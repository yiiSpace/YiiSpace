<?php

use yii\widgets\ActiveForm;

echo \frontend\widgets\Alert::widget() ;

?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'
    ]
]) ?>
<?= \yii\helpers\Html::errorSummary($model) ?>

<?= $form->field($model, 'name')->textInput() ?>

<?= $form->field($model, 'files[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

<button>Submit</button>

<?php ActiveForm::end() ?>
