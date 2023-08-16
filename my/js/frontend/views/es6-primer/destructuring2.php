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
    /** ## Set 解构 */
    {
        let [x, y, z] = new Set(['a', 'b', 'c']);
        x // "a"
        console.log('[Set-destruct]:', x, y, z);
    }
    // 事实上，只要某种数据结构具有 Iterator 接口，都可以采用数组形式的解构赋值。
    {
        function* fibs() {
            let a = 0;
            let b = 1;
            while (true) {
                yield a;
                [a, b] = [b, a + b];
            }
        }

        let [first, second, third, fourth, fifth, sixth] = fibs();
        sixth // 5
        console.log('[iterator-destruct]:', first, second, third, fourth, fifth, sixth);

    }

    /**
     * 遍历 Map 结构
     *
     * 任何部署了 Iterator 接口的对象，都可以用for...of循环遍历。
     * Map 结构原生支持 Iterator 接口，配合变量的解构赋值，获取键名和键值就非常方便。
     */
    {
        const map = new Map();
        map.set('first', 'hello');
        map.set('second', 'world');

        for (let [key, value] of map) {
            console.log(key + " is " + value);
        }
        // first is hello
        // second is world
        for (let [key, ] of map) {
            console.log( 'key is :', key );
        }
        for (let [ ,value ] of map) {
            console.log( 'value is :', value );
        }
    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>

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