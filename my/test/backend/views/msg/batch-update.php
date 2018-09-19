<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $items my\test\common\models\Msg[] */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'batch update Msg';
$this->params['breadcrumbs'][] = ['label' => 'Msgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form batch-msg-form">
    <?php $form = ActiveForm::begin(); ?>

    <table class="table  table-striped">

        <tr>
            <th>
<!--                这里是首位 隐藏域占位用的-->
            </th>
                      <th> type </th>
          <th> uid </th>
          <th> data </th>
          <th> snd_type </th>
          <th> snd_status </th>
          <th> priority </th>
          <th> to_id </th>
          <th> msg_pid </th>
          <th> create_time </th>
          <th> sent_time </th>
          <th> delete_time </th>
        </tr>

        <?php  foreach($items as $i=>$item): ?>
            <tr>
                <td>
                    <?=  Html::hiddenInput('selection[]',$item->primaryKey) ?>
                </td>
                                 <td> <?= $form->field($item,"[$i]type")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]uid")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]data")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]snd_type")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]snd_status")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]priority")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]to_id")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]msg_pid")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]create_time")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]sent_time")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]delete_time")->label(false) ?> </td> 

            </tr>
        <?php  endforeach; ?>

    </table>

    <?=  Html::submitButton('Save',[
        'class' => 'btn btn-primary',
    ]); ?>

    <?php  ActiveForm::end(); ?>
</div><!-- form -->