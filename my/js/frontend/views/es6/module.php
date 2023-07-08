<?php

use common\widgets\ViewInfo;
use macgyer\yii2materializecss\widgets\Modal;
use my\js\frontend\JsAsset;
use yii\helpers\Inflector;

/**   @var \yii\web\View $this  /
/**    @var string $content  */

// 注册js｜css 所需的asset
$asset = \common\widgets\PrismAsset::register($this);
$jsAsset = JsAsset::register($this);
echo $jsAsset->baseUrl ;
?>

<?php $this->beginBlock('my-es-code'); ?>
<script>
    // 简单例子🌰  
    {
      // module 模式 Node环境不支持的
      /**
       * 引入方法 类似
       * ...script type="module" src="public/js/my_page.js" ...
       * 
       * ⚠️浏览器缓存问题 js编辑后 不加载新版本 一直用老版本😄
       */

       /**
        * Node 环境下 模块规范用的是CommonJs
        * module.export = {
        *   ... 
        * 
        * }
        * 导入：
        * const xx = require('../my_module.js') ;
        * 
        * 早期js模块化规范 都混战过：CommonJs AMD CMD 
        */
        
    }
</script>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('my-es-code2'); ?>
<script>
    // 简单例子🌰  
    {
      
        
    }
</script>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('my-es-code3'); ?>
<script>
    // 简单例子🌰  
    {
      
        
    }
</script>
<?php $this->endBlock(); ?>

<script type="module" src="<?= $jsAsset->baseUrl.'/js/my_page.js' /*.'&ts='.time();*/ ?>"></script>

<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> <?= Inflector::camelize($this->context->action->id) ?> </h4>

    <p>

    </p>

    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3">
                    <a href="#test1" class="active">模块化 基础</a>
                </li>
                <li class="tab col s3">
                    <a href="#test2">其他</a>
                </li>
                <li class="tab col s3">
                    <a href="#test3">...</a>
                </li>
            </ul>
        </div>

        <div id="test1" class="col s12">

            <pre>
            <code class="language-js">
                <?= \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code'])  ?>
                </code>
            </pre>

        </div>

        <div id="test2" class="col s12">
            <pre>
            <code class="language-js">
                <?= \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code2'])  ?>
                </code>
            </pre>
        </div>

        <div id="test3" class="col s12">
            <pre>
            <code class="language-js">
                <?= \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code3'])  ?>
                </code>
            </pre>
        </div>

    </div>



</div>


<?php \year\widgets\JsBlock::begin() ?>
<?= $this->blocks['my-es-code'] ?>
<?= $this->blocks['my-es-code2'] ?>
<?= $this->blocks['my-es-code3'] ?>
<?php \year\widgets\JsBlock::end() ?>

<?php \year\widgets\JsBlock::begin() ?>
<script>
    function _alert(msg) {
        M.toast({
            text: msg,
            classes: 'rounded'
        });
    }

    document.addEventListener('DOMContentLoaded', function() {

        // Tabs 初始化
        var el = document.querySelectorAll('.tabs');
        var options = {};
        var instance = M.Tabs.init(el, options);
    });
</script>
<?php \year\widgets\JsBlock::end() ?>


<?php \year\widgets\CssBlock::begin() ?>
<style>

</style>
<?php \year\widgets\CssBlock::end() ?>