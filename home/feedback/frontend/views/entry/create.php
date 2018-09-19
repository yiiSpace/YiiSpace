<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model home\feedback\common\models\Feedback */

$this->title = '创建反馈';
$this->params['breadcrumbs'][] = ['label' => '信件列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
