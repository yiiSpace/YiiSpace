<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model my\test\common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
            'username',
            'password',
            'icon_uri',
            'email:email',
            'activkey',
            'superuser',
            'status',
            'create_at',
            'lastvisit_at',
        ],
    ]) ?>

       <?php   \year\charisma\Box::end() ?>
</div>
