<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model my\test\common\models\Msg */

$this->title = 'Update Msg: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Msgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="msg-update">

      <?php    \year\charisma\Box::begin([
            'options'=>[
            'class'=>'col-md-12'
    ],
         'headerTitle'=>'<i class="glyphicon glyphicon-edit"></i> '.Html::encode($this->title),
         'headerIcons'=>[
            '<a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>',
         ]
    ]) ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

       <?php   \year\charisma\Box::end() ?>
</div>
