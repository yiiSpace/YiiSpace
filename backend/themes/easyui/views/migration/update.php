<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Migration */

$this->title = 'Update Migration: ' . ' ' . $model->version;
$this->params['breadcrumbs'][] = ['label' => 'Migrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->version, 'url' => ['view', 'id' => $model->version]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="migration-update">

    <div class="easyui-panel" title="<?= Html::encode($this->title) ?>" style="width:100%;padding:10px;">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    </div>

</div>
