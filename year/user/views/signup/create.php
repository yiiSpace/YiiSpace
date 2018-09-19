<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model year\user\models\User */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => '用户',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>
 <?php /*
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
*/ ?>

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'verifyPassword')->passwordInput(['maxlength' => 255]) ?>


        <div class="form-group">
            <?= Html::submitButton( Yii::t('app', 'Create') , ['class' =>  'btn btn-success' ]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
