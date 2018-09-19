<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model home\feedback\common\models\Feedback */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Feedbacks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-view">

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
            'cate_id',
            'type_id',
            'username',
            'id_card',
            'tel',
            'contact_address',
            'subject',
            'body:ntext',
            'reply_department',
            'reply_at',
            'reply_content:ntext',
            'admin_updated_by',
            'created_at',
            'updated_at',
            'status',
        ],
    ]) ?>

</div>
