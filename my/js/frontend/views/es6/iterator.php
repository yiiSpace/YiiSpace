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
        function* id() {
            yield 1;
            yield 2;
            yield 3;
        }
        let iter = id();

        console.log(iter.next());
        console.log(iter.next());
        console.log(iter.next());
        console.log(iter.next());
        console.log(iter.next());

        let it = id();
        for (item in it) {
            console.log(item);
        }
    } 
    // 
    {
       let  cit = function*(items = []) {
            for (let i = 0; i < items.length; i++) {
                yield items[i];
            }
        }

        let it = cit([1,2,3,4,5,6,7,8,9,10]) ;

        console.log(it.next().value) ;
    }

    // 实现迭代器的数据结构
    {
        let items  = [1,2,3,4,5] ;
        for(let i of items){
            console.log(i );
        }

        // 都返回的是迭代器
        console.log(items.keys()) ;
        console.log(items.values()) ;
        console.log(items.entries()) ;

        for (const [k, v] of items.entries()) {
            console.log(k,'=>',v) ;
        }

        // map 也实现了迭代器
        let m = new Map();
        m.set('name','qing');
        m.set('name2','qing2');

        for(const item of m){
            console.log(item);
        }

    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> 迭代器 </h4>
    <p>
    数组 ｜ Map ｜ Set 都实现了迭代器
    </p>
    <div>
        <pre><code class="language-js">
    <?= \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code'])  ?>
    </code></pre>
    </div>

</div>


<?php \year\widgets\JsBlock::begin() ?>
<?= $this->blocks['my-es-code'] ?>
<?php \year\widgets\JsBlock::end() ?>

<?php \year\widgets\JsBlock::begin() ?>
<script>
    function _alert(msg) {
        M.toast({
            text: msg,
            classes: 'rounded'
        });
    }
</script>
<?php \year\widgets\JsBlock::end() ?>


<?php \year\widgets\CssBlock::begin() ?>
<style>

</style>
<?php \year\widgets\CssBlock::end() ?>