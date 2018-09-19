<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('Update {modelClass}: ', ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?> . ' ' . $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model-><?= $generator->getNameAttribute() ?>, 'url' => ['view', <?= $urlParams ?>]];
$this->params['breadcrumbs'][] = <?= $generator->generateString('Update') ?>;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update">

    <?= "  <?php " ?>   \year\charisma\Box::begin([
            'options'=>[
            'class'=>'col-md-12'
    ],
         'headerTitle'=>'<i class="glyphicon glyphicon-edit"></i> '.Html::encode($this->title),
         'headerIcons'=>[
            '<a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>',
         ]
    ]) ?>

    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>

    <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]) ?>

    <?= "   <?php " ?>  \year\charisma\Box::end() ?>
</div>
