<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12 center login-header">
        <h2>欢迎登陆 <em><?= Yii::$app->name ?></em> 后台系统</h2>
    </div>
    <!--/span-->
</div><!--/row-->

<div class="row">
    <div class="well col-md-5 center login-box">
        <div class="alert alert-info">
            Please login with your Username and Password.
            <?= Html::errorSummary($model) ?>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => [
                'class' => 'form-horizontal'
            ]
        ]); ?>

        <fieldset style="padding: 15px">


            <!--                <input type="text" class="form-control" placeholder="Username">-->

            <?= $form->field($model, 'username', [
                'template' => '  <div class="input-group input-group-lg">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span> {input}  </div> '
            ])->textInput([
                'placeholder' => "Username",
            ]) ?>


            <div class="clearfix"></div>
            <br>


            <!--
                            <input type="password" class="form-control" placeholder="Password">
            -->
            <?= $form->field($model, 'password', [
                'template' => '<div class="input-group input-group-lg">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>{input}</div>',
            ])->passwordInput([
                'placeholder' => 'Password'
            ])->label(false) ?>

            <div class="clearfix"></div>

            <div class="input-prepend">

                <?= $form->field($model, 'rememberMe')->checkbox()->label(null, ['class' => 'remember']) ?>

            </div>
            <div class="clearfix"></div>

            <p class="center col-md-5">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </p>
        </fieldset>

        <?php ActiveForm::end(); ?>

    </div>
    <!--/span-->
</div><!--/row-->
