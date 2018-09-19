<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model home\feedback\common\models\Feedback */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => '信件列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除此条信息?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('打印', 'javascript:void(0);', [
            'class' => 'btn btn-success',
            'onclick'=>'printThis()'
        ]) ?>
        <?php \year\widgets\JPrintThisAsset::register($this) ?>
        <?php \year\widgets\JsBlock::begin() ?>
        <script>

            function printThis() {
                $('#kv-demo').printThis({
                    // importCSS: false,
                    // loadCSS: "",
                    header: "<h1></h1>"
                });
            }
        </script>
        <?php \year\widgets\JsBlock::end() ?>
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
                    'label'=>'反馈人',
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:30%'],
                ],
                [
                    'attribute'=>'id_card',
                    // 'value'=>'<kbd>'.$model->subject.'</kbd>',
                    'valueColOptions'=>['style'=>'width:30%'],
                    'displayOnly'=>true
                ],
            ],
        ],
        [
            'columns' => [
                [
                    'attribute'=>'tel',
                    'displayOnly'=>true,
                    'valueColOptions'=>['style'=>'width:30%'],
                ],
                [
                    'attribute'=>'contact_address',
                    // 'value'=>'<kbd>'.$model->subject.'</kbd>',
                    'valueColOptions'=>['style'=>'width:30%'],
                    'displayOnly'=>true
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
            'columns' => [
                [
                    'attribute'=>'status',
                    'format'=>'raw',
                    'value'=>'<kbd>'.$model->getStatusTitle().'</kbd>' ,
                ],
                [
                    'attribute'=>'hot_grade',
                    'valueColOptions'=>['style'=>'width:30%'],
                    'format'=>'raw',
                    'value'=>$model->hot_grade ? '<span class="label label-success">是</span>' : '<span class="label label-danger">否</span>',
                ],
            ],
        ],
        [
           'attribute'=>  'user_ip',
            'label'=>'提交者ip地址',
        ]
    ];

    // View file rendering the widget
    echo \kartik\detail\DetailView::widget([
        'options'=>[

        ],
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
