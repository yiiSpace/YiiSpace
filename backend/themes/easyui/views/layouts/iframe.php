<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
// EasyuiAsset::register($this);

use sansusan\easyui\EasyuiAsset;

EasyuiAsset::register($this,
    [
       // 'theme' => 'metro-gray',
        'theme' => 'default',
        'locale' => 'easyui-lang-zh_CN'],
    ['datagrid-groupview']
);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <?php // \year\web\CSRF4Ajax::widget() ?>

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>
<body class="easyui-layout" style="text-align:left">

<div data-options="region:'center',title:'Center'">

            <h1>
                <?= '&nbsp;' . Html::encode($this->title) ?>
                <small><?php echo \Yii::$app->controller->id . '-' . \Yii::$app->controller->action->id; ?></small>
            </h1>
            <?php
            $breadcrumbs = isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [];
            foreach (Yii::$app->controller->modules as $module) {
                if ($module != Yii::$app) {
                    array_unshift($breadcrumbs, ['label' => Inflector::camel2words($module->id), 'url' => ['/' . $module->uniqueId]]);
                }
            }
            ?>
            <?=
            Breadcrumbs::widget([
                'tag' => 'ol',
                'encodeLabels' => false,
                'homeLink' => ['label' => '<i class="fa fa-dashboard"></i> Home/Dashboard', 'url' => ['/site/index']],
                'links' => $breadcrumbs,
            ])
            ?>
                    <?php echo $content; ?>
</div>


<!-- 由于iframe的缘故 居中可能位置偏下了  style="width:400px;height:280px;padding:10px 20px"  可用top控制位置-->
<div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px; top:120px"
     closed="true" buttons="#dlg-buttons"
     data-options="onResize:function(){
            // $(this).dialog('center');
        }"
    >
    <div id="ajax_form">稍等......</div>
</div>
<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6"
       iconCls="icon-ok" id="save_ajax_form" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton"
       iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div>

<?php \year\widgets\JsBlock::begin()?>
<script>

    /**
     *
     *
     * */
    function formPost(url, params, target) {
        // 如果未指定提交窗体 那么提交到新开的tab窗体中去
        if (undefined == target) {
            target = '_blank';
        }
        var opts = {
            id: 'vForm',
            //  name:'_helper_form',
            action: url,
            method: 'post',
            target: '_blank',
            style: 'display:none'
        };
        // var inpQ =  $('#inpQ').clone();
        var $newForm = $('<form/>', opts);
        /*
         if (params !== undefined && (typeof params == 'object')) {
         }else{
         params = {} ;
         }
         */
        params = params || {};
        // 推入csrf令牌 不然yii的post提交不会通过的！
        var csrfParam = $('meta[name=csrf-param]').prop('content');
        var csrfToken = $('meta[name=csrf-token]').prop('content');
        params[csrfParam] = csrfToken;

        for (k in params) {
            var $paramInput = $('<input>',
                {
                    name: k,
                    type: 'hidden',
                    value: params[k]
                });
            $newForm.append($paramInput);
        }
        $('body').append($newForm);
        $newForm.trigger('submit');
        $newForm.remove();
    }
</script>
<?php \year\widgets\JsBlock::end()?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
