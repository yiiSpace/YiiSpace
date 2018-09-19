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

$modelId = Inflector::camel2id(StringHelper::basename($generator->modelClass));

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="<?= $modelId  ?>-form" >

    <?= "<?php " ?>$form = ActiveForm::begin(
            [
                'options' => [
                    'class' => 'ui-form',
                     'id'=>'yiiAF_<?= $modelId ?>',
                    // 此处比较重要！yii默认会为没有id的widget生成id的 如果是ajax加载 会导致id冲突的 这样js中有些代码就失效了
                    // 这个最容易根search表单的id冲突  参考yiiActiveForm.js 源码就可以看出问题所在了！
                    // 'id'=>'form-'.time(),
                 ],
            'fieldConfig' => [
                'template' => "<td>{label}</td>\n<td>{input}</td>\n<td>{error}</td>",
                //  'template' => "{input} \n {error}",
                // 'labelOptions' => ['class' => 'ui-label'],
                // 'inputOptions' => ['class' => 'ui-input'],
                'options' => ['tag' => 'tr'],
                 ],
            ]
    ); ?>

    <?= "<?php " ?>$form->errorSummary($model); ?>

    <table>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?php echo " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>
    </table>

    <div class="form-group" style="text-align:center;padding:5px">
        <?= "<?php echo " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('Create') ?> : <?= $generator->generateString('Update') ?>, ['class' => $model->isNewRecord ? 'btn btn-success easyui-linkbutton' : 'btn btn-primary easyui-linkbutton']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
