<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $items <?= ltrim($generator->modelClass, '\\') ?>[] */
/* @var $form yii\widgets\ActiveForm */

$this->title = <?= $generator->generateString('batch update {modelClass}', ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form batch-<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    <?= "<?php " ?>$form = ActiveForm::begin(); ?>

    <table class="table  table-striped">

        <tr>
            <th>
<!--                这里是首位 隐藏域占位用的-->
            </th>
            <?php foreach ($generator->getColumnNames() as $attribute) {
                if (in_array($attribute, $safeAttributes)) {
                    $th = <<<TH
          <th> {$attribute} </th>
TH;
                    echo $th ."\n";
                }
            } ?>
        </tr>

        <?= "<?php " ?> foreach($items as $i=>$item): ?>
            <tr>
                <td>
                    <?= "<?= " ?> Html::hiddenInput('selection[]',$item->primaryKey) ?>
                </td>
                <?php
                 /*
                <td><?= $form->field($item,"[$i]name"); ?></td>
               <?php */ ?>
                <?php foreach ($generator->getColumnNames() as $attribute) {
                    if (in_array($attribute, $safeAttributes)) {
                        echo " <td> <?= \$form->field(\$item,\"[\$i]{$attribute}\")->label(false) ?> </td> \n\n";
                    }
                } ?>
            </tr>
        <?= "<?php " ?> endforeach; ?>

    </table>

    <?= "<?= " ?> Html::submitButton('Save',[
        'class' => 'btn btn-primary',
    ]); ?>

    <?= "<?php " ?> ActiveForm::end(); ?>
</div><!-- form -->