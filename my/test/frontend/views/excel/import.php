<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model  \my\test\common\models\FileModel */

$this->title = 'import';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-import">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        上传测试.
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id' => 'import-form',
                'options' => [
                    'enctype' => 'multipart/form-data',
                ]

            ]); ?>
            <?= $form->field($model, 'file')->fileInput([

            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'import-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
