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

    <h1><?php  // Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-10">
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
        <div class="col-md-2">
            <p>
                <?php // echo Html::a('创建反馈', ['create'], ['class' => 'btn btn-success']) ?>
            </p></div>
    </div>




    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">
                <div class="row">
                    <div class="col-md-4">  </div>
                    <div class="col-md-4 col-md-offset-4">
                        <a class="btn btn-success quick-type-search btn-xs" role="button"
                           data-type-value="<?= \home\feedback\common\models\Feedback::TYPE_CONSULT ?>">
                            咨询
                        </a>
                        <a class="btn btn-warning quick-type-search btn-xs" role="button"
                           data-type-value="<?= \home\feedback\common\models\Feedback::TYPE_COMPLAINT ?>">
                            投诉
                        </a>
                        <a class="btn btn-primary quick-type-search btn-xs" role="button"
                           data-type-value="<?= \home\feedback\common\models\Feedback::TYPE_SUGGESTION ?>">
                            建议
                        </a>

                        <a class="btn btn-info quick-type-search btn-xs" role="button"
                           data-type-value="<?= 1 ?>"
                           data-field-name="<?= Html::getInputName($searchModel,'hot_grade') ?>">
                            热点回复
                        </a>

                    </div>

                    <?php \year\widgets\JsBlock::begin() ?>
                    <script>
                        $(function () {
                            $(document).on('click','a.quick-type-search' ,function (e) {
                               var value =    $(this).data('type-value');
                                var $input  ;
                               if($(this).data('field-name')){
                                   $input = $(':input[name="'+$(this).data('field-name')+'"]')
                               }else{
                                   // 设置搜索值.
                                    $input = $(':input[name="FeedbackSearch[type_id]"]') ;
                               }
                                $input.val(value) ;
                                $input.closest('form').submit() ;
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
                        'attribute'=>'hot_grade',
                        'value'=>function($model){
                            return $model->getHotGradeTitle() ;
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header'=>'查看',
                        'template' => '{view} '
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
