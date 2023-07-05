<?php

use common\widgets\ViewInfo;
use macgyer\yii2materializecss\widgets\Modal;

/**   @var \yii\web\View $this  /
/**    @var string $content  */

// 注册js｜css 所需的asset
$asset = \common\widgets\PrismAsset::register($this);
?>

<?php $this->beginBlock('my-es-code'); ?>
<script>
    // 简单例子🌰  
    {
        let p = new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve('some value from networks!');
            }, 3800);
        });
        let p2 = new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve('some value2 from networks!');
            }, 800);
        });

        let as = async () => {
            let result = await p;
            let result2 = await p2;
            console.log(result);
            console.log(result2);
        };

        as();

        // all 
        let as_all = async function(){
            let all = [await p, await p2];
            console.log(all) ; 
        };
        as_all();
    }
</script>
<?php $this->endBlock(); ?>
<?php $this->beginBlock('my-es-code2'); ?>
<script>
    // 简单例子🌰  
    {
       let hi_async = async ()=>{
         return 'hi_async result' ; // 这个值相当于被Promise.resove(); 装箱了
       };

       console.log(hi_async()) ; // 可以控制台看返回值类型
       hi_async().then(value=>{
        console.log(value) ;
       });

       console.log() ;

       let as2 = async ()=>{
         let result = await hi_async();
         return result ;
       };
       as2().then(result => {
            console.log(result) ;
       });
    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> Async </h4>
    <p>

    </p>

    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3">
                    <a href="#test1" class="active">异步 基础</a>
                </li>
                <li class="tab col s3">
                    <a href="#test2">异步 嵌套</a>
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

    </div>



</div>


<?php \year\widgets\JsBlock::begin() ?>
<?= $this->blocks['my-es-code'] ?>
<?= $this->blocks['my-es-code2'] ?>
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