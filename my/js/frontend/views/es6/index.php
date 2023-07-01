<?php
use common\widgets\ViewInfo;

/** @var \yii\web\View $this */
/** @var string $content */

// 注册js｜css 所需的asset

$asset =\common\widgets\PrismAsset::register($this);
// 手动加载插件的代码示例
// $cdnUrl = $asset->getCDNUrl();
// $pluginJs = $cdnUrl.'/plugins/autoloader/prism-autoloader.min.js';

// array_push($asset->js,$pluginJs) ; 

?>

 <?php $this->beginBlock('my-es-code'); ?>
 <script>
    console.log(some_value_not_defined) // ⚠️注意跟 undefined的区别 定义了 但未初始化就是undefined
    console.log(value); // 可以后向访问！ 看👀控制台输出！
{
    var value = 10 ; // var 有变量提升能力 均视为作用域顶部声明
    let count = 20 ;

}
console.log(value);
// console.log(count) ; // ⚠️ 出现错误后 会导致左侧菜单有些功能异常 count 出作用域块后就不能再被访问

console.log(not_defined_let_var);
console.log(defined_let_var);
let defined_let_var ; // 只不过没有初始化
</script>
 <?php $this->endBlock(); ?>



<div class="js-es6-index">
<? // ViewInfo::widget(); ?>

    <div>
    <pre><code class="language-js">
    <?=  \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code'])  ?>
    </code></pre>
    </div>
</div>


<?php \year\widgets\JsBlock::begin() ?>

<?= $this->blocks['my-es-code'] ?>

<?php \year\widgets\JsBlock::end() ?>


<?php \year\widgets\CssBlock::begin() ?>
<style>
   
</style>
<?php \year\widgets\CssBlock::end() ?>