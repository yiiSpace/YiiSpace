<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel my\test\common\models\MsgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Msgs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msg-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="panel panel-default">
        <div class="panel-body">

    <p>
        <?= Html::a('Create Msg', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

            <?=  Html::beginForm( '','post', [ 'class'=>'grid-batch-action-form'] ) ?>

    <?= GridView::widget([
        'id' => 'msg-grid',
        'layout' => "  <div id='pl_grid_tools_bar'></div> {pager} \n {items}\n{summary}  \n {pager} ",
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],
              ['class' => \yii\grid\CheckboxColumn::className()],

            'id',
            'type',
            'uid',
            'data:ntext',
            'snd_type',
            // 'snd_status',
            // 'priority',
            // 'to_id',
            // 'msg_pid',
            // 'create_time:datetime',
            // 'sent_time:datetime',
            // 'delete_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

            <?=  Html::endForm() ?>

        </div>
        <div class="panel-footer"></div>

    </div>

</div>

   <?php  \year\widgets\PageletBlock::begin(['targetId'=>'pl_grid_tools_bar']) ?>

<div class="panel panel-default">
    <div class="panel-body">
        <a class="btn">
            <input type="checkbox"  name="selection_all" class="select-on-check-all copy">
        </a>
                <div class="btn-group batch-action-buttons" role="group" aria-label="..." >
               <?=  Html::submitButton( 'DELETE',[
                'name'=>'batchDelete' ,
                'class'=>'batch-action-button btn btn-danger btn-sm' , // btn-xs
                'data'=>[
                    'action'=>'batch-delete',
                    'confirm-message'=>'do you want to perform this action ?',
                ]
            ]) ?>
               <?=  Html::submitButton('UPDATE',[
                'name'=>'batchUpdate' ,
                'class'=>'batch-action-button btn btn-info btn-sm' , // btn-xs
                'data'=>[
                    'action'=>\yii\helpers\Url::to(['batch-update'])
                ]
            ]) ?>
        </div>
    </div>
</div>
   <?php  \year\widgets\PageletBlock::end() ?>
   <?php  \year\widgets\JsBlock::begin() ?>
<script>
    $(function(){
        /**
         * ========================================================================================= begin \\
         */
        syncCheckBox('.select-on-check-all.copy','.select-on-check-all');
        syncCheckBox('.select-on-check-all','.select-on-check-all.copy');

        /**
         * 同步两个复选框 主复选框选中时 从复选框也选中
         * @param masterSelector
         * @param slaveSelector
         */
        function syncCheckBox(masterSelector,slaveSelector){
            $(document).on("click",masterSelector,function(){
                $(slaveSelector).prop('checked', this.checked);
            });
        }
        /**
         * =========================================================================================  end  //
         */
        // 多选框选中后执行 ！  注意不准哦 最好用定时器延时执行
        $(document).on('click',':checkbox',function(){
            var keys = $(this).closest('.grid-view').yiiGridView('getSelectedRows');
            // alert(keys.length) ;
        });
        /*
         // 批量处理表单提交前
         // get the form id and set the event
         $('form.grid-batch-action-form').on('beforeSubmit', function(e) {
         var \$form = $(this);
         // do whatever here, see the parameter \$form?
         // is a jQuery Element to your form
         }).on('submit', function(e){
         e.preventDefault();
         });
         */
        $(".batch-action-button").on("click",function(e){

            var keys = $(this).closest('.grid-view').yiiGridView('getSelectedRows');
            if( keys.length == 0 ){
                alert("没有选中任何数据项!");
                return false ;
            }

            var confirmMessage = $(this).data('confirm-message') || '确定要执行此批量操作？';
            if(confirm(confirmMessage)){
                // 表单提交前用当前按钮的url换掉表单的action动作
                $(this).closest('form').attr('action',$(this).data('action'));
            }else{
                return false ;
            }
        });
    });

</script>
   <?php  \year\widgets\JsBlock::end() ?>

