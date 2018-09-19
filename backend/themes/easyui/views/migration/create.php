<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Migration */

$this->title = 'Create Migration';
$this->params['breadcrumbs'][] = ['label' => 'Migrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="migration-create">

    <div class="easyui-panel" title="<?= Html::encode($this->title) ?>" style="width:100%;padding:10px;">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    </div>
</div>
