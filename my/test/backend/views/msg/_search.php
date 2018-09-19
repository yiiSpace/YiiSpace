<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model my\test\common\models\MsgSearch */
/* @var $form yii\widgets\ActiveForm */
?>

  <?php    \year\charisma\Box::begin([
                'options'=>[
                      'class'=>'col-md-12'
                ],
            'headerTitle'=>'<i class="glyphicon glyphicon-search"></i> '.Html::encode($this->title),
            'headerIcons'=>[
                  '<a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>',
             ]
        ]) ?>


        <div class="msg-search">

            <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options'=>[
            'class'=>'', // form-inline
            ],
            ]); ?>

            <div class="row"> 

 <div class="col-xs-4">  

     <?= $form->field($model, 'id') ?>

</div> 

 <div class="col-xs-4">  

     <?= $form->field($model, 'type') ?>

</div> 

 <div class="col-xs-4">  

     <?= $form->field($model, 'uid') ?>

</div> 

 </div> 

 <div class="row"> 

 <div class="col-xs-4">  

     <?= $form->field($model, 'data') ?>

</div> 

 <div class="col-xs-4">  

     <?= $form->field($model, 'snd_type') ?>

</div> 

 <div class="col-xs-4">  

     <?= $form->field($model, 'snd_status') ?>

</div> 

 </div> 

 <div class="row"> 

 <div class="col-xs-4">  

     <?= $form->field($model, 'priority') ?>

</div> 

 <div class="col-xs-4">  

     <?= $form->field($model, 'to_id') ?>

</div> 

 <div class="col-xs-4">  

     <?= $form->field($model, 'msg_pid') ?>

</div> 

 </div> 

 <div class="row"> 

 <div class="col-xs-4">  

     <?= $form->field($model, 'create_time') ?>

</div> 

 <div class="col-xs-4">  

     <?= $form->field($model, 'sent_time') ?>

</div> 

 <div class="col-xs-4">  

     <?= $form->field($model, 'delete_time') ?>

</div> 

 </div> 

 </div> 

             <div class="form-group row">
<!--                pull-right-->
                <div  class="col-xs-offset-10">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>


</div>

   <?php   \year\charisma\Box::end() ?>
