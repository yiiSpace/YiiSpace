<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel home\feedback\common\models\FeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '信件列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Feedback', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">
                <div class="row">
                    <div class="col-md-4">
<!--                        热点回复-->
                    </div>
                    <div class="col-md-4 col-md-offset-4">
                        <a class="btn btn-success quick-type-search" role="button"
                           data-type-value="<?= \home\feedback\common\models\Feedback::TYPE_CONSULT ?>">
                            咨询
                        </a>
                        <a class="btn btn-warning quick-type-search" role="button"
                           data-type-value="<?= \home\feedback\common\models\Feedback::TYPE_COMPLAINT ?>">
                            投诉
                        </a>
                        <a class="btn btn-primary quick-type-search" role="button"
                           data-type-value="<?= \home\feedback\common\models\Feedback::TYPE_SUGGESTION ?>">
                            建议
                        </a>
                        <a class="btn btn-info quick-type-search" role="button"
                           data-type-value="<?= \home\feedback\common\models\Feedback::TYPE_TO_DIRECTOR ?>">
                            局长来信
                        </a>
                    </div>

                    <?php \year\widgets\JsBlock::begin() ?>
                    <script>
                        $(function () {
                            $(document).on('click','a.quick-type-search' ,function (e) {
                               var value =    $(this).data('type-value');
                               // 设置搜索值
                                var $typeSelectionInput = $(':input[name="FeedbackSearch[type_id]"]') ;
                                $typeSelectionInput.val(value) ;
                                $typeSelectionInput.closest('form').submit() ;
                            });
                        });

                    </script>
                    <?php \year\widgets\JsBlock::end() ?>
                </div>
            </h3>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => null , // $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //  'id',
                    // 'cate_id',
                    // 'type_id',
                    [
                      'attribute'=>'type_id',
                        'value'=>function($model){
                          return   $model->getTypeTitle() ;
                        }
                    ],
                    // 'username',
                    // 'id_card',
                    // 'tel',
                    // 'contact_address',
                    'subject',
                    // 'body:ntext',

                    // 'reply_at',
                    // 'reply_content:ntext',
                    // 'admin_updated_by',
                    // 'created_at',
                     'updated_at:datetime',

                    'reply_department',
                     // 'status',
                    [
                        'attribute'=>'status',
                        'value'=>function($model){
                            return $model->getStatusTitle() ;
                        },
                    ],
                    [
                        'header'=>'是否热门',
                        'class' => \porcelanosa\yii2togglecolumn\ToggleColumn::className(),
                        'attribute' => 'hot_grade',
                        // Uncomment if  you don't want AJAX
                        'enableAjax' => true,
                        'contentOptions' => ['style' => 'width:50px;'],
                        'value'=>function($model){
                            return $model->getHotGradeTitle() ;
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
