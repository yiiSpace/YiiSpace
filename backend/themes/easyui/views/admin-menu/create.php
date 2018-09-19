<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AdminMenu */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Admin Menu',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-menu-create">

    <div class="easyui-panel" title="<?= Html::encode($this->title) ?>" style="width:100%;padding:10px;">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    </div>
</div>
