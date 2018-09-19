<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var my\test\common\models\Token $model
*/

$this->title = $model->getAliasModel() . $model->user_id . ', ' . Yii::t('app', 'Edit');
$this->params['breadcrumbs'][] = ['label' => $model->getAliasModel(true), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->user_id, 'url' => ['view', 'user_id' => $model->user_id, 'code' => $model->code, 'type' => $model->type]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Edit');
?>
<div class="giiant-crud token-update">

    <h1>
        <?= $model->getAliasModel() ?>        <small>
                        <?= $model->user_id ?>        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> ' . Yii::t('app', 'View'), ['view', 'user_id' => $model->user_id, 'code' => $model->code, 'type' => $model->type], ['class' => 'btn btn-default']) ?>
    </div>

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
