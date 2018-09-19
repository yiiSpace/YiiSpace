<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <div class="easyui-panel" title="<?= Html::encode($this->title) ?>" style="width:100%;padding:10px;">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    </div>
</div>
