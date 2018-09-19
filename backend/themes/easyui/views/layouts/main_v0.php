<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/*
use dee\easyui\EasyuiAsset;
use dee\easyui\NavTree;
*/
/**
 * @var \yii\web\View $this
 * @var string $content
 */
// EasyuiAsset::register($this);

use sansusan\easyui\EasyuiAsset;

EasyuiAsset::register($this,
    ['theme' => 'metro-gray', 'locale' => 'easyui-lang-zh_CN'],
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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>
<body class="easyui-layout" style="text-align:left">

<div data-options="region:'north',border:false" style="height:60px;background:#B3DFDA;padding:10px">
    north region

</div>
<div data-options="region:'west',split:true,title:'West'" style="width:200px;padding:5px;">


    <div class="easyui-accordion" data-options="fit:true" >

        <div title="About" data-options="selected:true" style="padding:5px;">
            <h3 style="color:#0099FF;">Accordion for jQuery</h3>
            <p>Accordion is a part of easyui framework for jQuery. It lets you define your accordion component on web page more easily.</p>
        </div>
        <div title="Title1" style="padding:5px">
            <ul class="easyui-tree">
                <li>
                    <span>Folder</span>
                    <ul>
                        <li>
                            <span>Sub Folder 1</span>
                            <ul>
                                <li>
                                    <span>File 11</span></li>
                                <li><span>File 12</span></li>
                                <li><span>File 13</span></li>
                            </ul>
                        </li>
                        <li><span>File 2</span></li>
                        <li><span>File 3</span></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="easyui-linkbutton" onclick="addTab('google','http://www.google.com')">google</a>
                </li>
                <li>
                    <a href="#" class="easyui-linkbutton" onclick="addTab('jquery','http://jquery.com/')">jquery</a>
                </li>
                <li>
                    <a href="#" class="easyui-linkbutton" onclick="addTab('easyui','http://jeasyui.com/')">easyui</a>
                </li>
            </ul>

        </div>
        <div title="Title2" style="padding:5px">
            <p>Content2</p>
        </div>
    </div>

</div>

<div data-options="region:'east',split:true,collapsed:true,title:'East'" style="width:100px;padding:10px;">
    east region
</div>

<div data-options="region:'south',border:false" style="height:50px;background:#A9FACD;padding:10px;">
    south region
</div>

<div data-options="region:'center',title:'Center'">

    <div class="easyui-layout" data-options="fit:true">
        <div region="north" border="false" style="height: 80px;">
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
        </div>
        <div region="center">

            <div id="tt" class="easyui-tabs" style="width:100%;height:1154px;">
                <div title="Home">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php \year\widgets\JsBlock::begin()?>
<script>
    function addTab(title, url){
        if ($('#tt').tabs('exists', title)){
            $('#tt').tabs('select', title);
        } else {
           // var content = '<iframe scrolling="auto" frameborder="0" src="'+url+'" style="width:100%;height:100%;"></iframe>';
            var content = '<iframe scrolling="auto" frameborder="0" src="'+url+'" style="width:100%;height:1154px;"></iframe>';
            $('#tt').tabs('add',{
                title:title,
                content:content,
                closable:true
            });
        }
    }
</script>
<?php \year\widgets\JsBlock::end()?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
