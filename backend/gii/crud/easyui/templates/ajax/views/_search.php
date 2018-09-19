<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div id="p" class="easyui-panel" title="search"
     style="width:100%;height:auto;padding:10px;background:#fafafa;"
     data-options="iconCls:'icon-search',closable:false,
    collapsible:true,maximizable:true">

    <div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search" style="padding:10px 60px 20px 60px">

        <?= "<?php " ?>$form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options'=>[
             'class'=>'search-form'  // 不能加 easyui-form类 不然js受影响！
             ],
        'fieldConfig' => [
                    'template' => "<td>{label}</td>\n<td>{input}</td>\n<td>{error}</td>",
                    'options' => ['tag' => 'tr'],
            ],
        ]); ?>

        <table cellpadding="5">
            <tbody>

            <?php
            $count = 0;
            foreach ($generator->getColumnNames() as $attribute) {
                if (++$count < 6) {
                    echo "    <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
                } else {
                    echo "    <?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
                }
            }
            ?>

            </tbody>
        </table>


        <div class="form-group" style="text-align:center;padding:5px">
            <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => 'easyui-linkbutton']) ?>
            <?= "<?= " ?>Html::resetButton(<?= $generator->generateString('Reset') ?>, ['class' => 'easyui-linkbutton' , 'onclick'=>'clearForm(this)']) ?>
        </div>

        <?= "<?php " ?>ActiveForm::end(); ?>

    </div>

</div>


<?= '<?php ' ?> \year\widgets\JsBlock::begin() ?>
<script>
    $(function(){
        $('form.search-form').on('submit', function(e){
            var $form = $(this);

            // var formData = form.serialize();
            var fields = $form.serializeArray();
            var params = {};
            $.each( fields, function(i, field){
                // 同时存在才保存！
                if(field.name && field.value){
                    params[field.name] = field.value
                }
            });

            $('#dg').datagrid('load',params);

            // 阻止表单提交！
            e.preventDefault();
        });
    });
    function clearForm(resetBtn){
        $(resetBtn).closest('form').form('clear');
    }
</script>
<?= '<?php ' ?> \year\widgets\JsBlock::end()?>
