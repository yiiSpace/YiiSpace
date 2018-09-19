<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model home\feedback\common\models\Feedback */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => '反馈列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php /* Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])  */ ?>
        <?php /* Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除此条信息?',
                'method' => 'post',
            ],
        ]) */ ?>
    </p>

    <?php
    // DetailView Attributes Configuration
    $attributes = [
        [
            'group'=>true,
            'label'=>'信件详情',
            'rowOptions'=>['class'=>'info']
        ],
        [
            'columns' => [
                [
                    'attribute'=>'id',
                    'label'=>'序号#',
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:30%'],
                    'value'=>$model->primaryKey,
                ],
                [
                    'attribute'=>'created_at',
                     'format'=>'datetime',
                     // 'value'=>'<kbd>'.$model->subject.'</kbd>',
                    'valueColOptions'=>['style'=>'width:30%'],
                    'displayOnly'=>true
                ],
            ],
        ],
        [
            'columns' => [
                [
                    'attribute'=>'username',
                    'label'=>'提交人',
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:30%'],
                    'value'=>$model->getCryptUserName() ,
                ],
                [
                    'attribute'=>'tel',
                    // 'value'=>'<kbd>'.$model->subject.'</kbd>',
                    'valueColOptions'=>['style'=>'width:30%'],
                    'displayOnly'=>true ,
                    'value'=>$model->getCryptTel() ,
                ],
            ],
        ],
        [
          'attribute'=>'subject',
        ],
        [
            'attribute'=>'body',
        ],
        [
            'columns' => [
                [
                    'attribute'=>'reply_department',
                ],
                [
                    'attribute'=>'reply_at',
                    'format'=>'datetime',
                    'valueColOptions'=>['style'=>'width:30%'],
                ],
            ],
        ],
        [
            'attribute'=>'reply_content',
        ],
        [
             'attribute'=>'status',
            'format'=>'raw',
            'value'=>'<kbd>'.$model->getStatusTitle().'</kbd>' ,
        ],
    ];

    // View file rendering the widget
    echo \kartik\detail\DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
        'mode' => 'view',
       /* 'bordered' => $bordered,
        'striped' => $striped,
        'condensed' => $condensed,
        'responsive' => $responsive,
        'hover' => $hover,
        'hAlign'=>$hAlign,
        'vAlign'=>$vAlign,
        'fadeDelay'=>$fadeDelay,
        'deleteOptions'=>[ // your ajax delete parameters
            'params' => ['id' => 1000, 'kvdelete'=>true],
        ],
       */
        'container' => ['id'=>'kv-demo'],
        // 'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
    ]);

    ?>
    <?php /*DetailView::widget([
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
    ])  */ ?>

</div>
