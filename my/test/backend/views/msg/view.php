<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model my\test\common\models\Msg */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Msgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msg-view">

      <?php    \year\charisma\Box::begin([
                'options'=>[
                         'class'=>'col-md-12'
                ],
                'headerTitle'=>'<i class="glyphicon glyphicon-eye-open"></i> '.Html::encode($this->title),
                 'headerIcons'=>[
                        '<a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>',
                ]
    ]) ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'uid',
            'data:ntext',
            'snd_type',
            'snd_status',
            'priority',
            'to_id',
            'msg_pid',
            'create_time:datetime',
            'sent_time:datetime',
            'delete_time:datetime',
        ],
    ]) ?>

       <?php   \year\charisma\Box::end() ?>
</div>
