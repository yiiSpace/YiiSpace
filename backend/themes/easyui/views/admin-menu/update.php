<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminMenu */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Admin Menu',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="admin-menu-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
