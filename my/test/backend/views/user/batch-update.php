<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $items my\test\common\models\User[] */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'batch update User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form batch-user-form">
    <?php $form = ActiveForm::begin(); ?>

    <table class="table  table-striped">

        <tr>
            <th>
<!--                这里是首位 隐藏域占位用的-->
            </th>
                      <th> username </th>
          <th> password </th>
          <th> icon_uri </th>
          <th> email </th>
          <th> activkey </th>
          <th> superuser </th>
          <th> status </th>
          <th> create_at </th>
          <th> lastvisit_at </th>
        </tr>

        <?php  foreach($items as $i=>$item): ?>
            <tr>
                <td>
                    <?=  Html::hiddenInput('selection[]',$item->primaryKey) ?>
                </td>
                                 <td> <?= $form->field($item,"[$i]username")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]password")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]icon_uri")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]email")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]activkey")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]superuser")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]status")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]create_at")->label(false) ?> </td> 

 <td> <?= $form->field($item,"[$i]lastvisit_at")->label(false) ?> </td> 

            </tr>
        <?php  endforeach; ?>

    </table>

    <?=  Html::submitButton('Save',[
        'class' => 'btn btn-primary',
    ]); ?>

    <?php  ActiveForm::end(); ?>
</div><!-- form -->