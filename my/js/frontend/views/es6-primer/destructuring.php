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
   

    /** ## 析构 数组 */
    {
        let [a, b, c] = [1, 2, 3];
        console.log('[destructuring-array]:', a, b, c);

    }
    {
        // 形状不匹配 多余的部分就会是undefined
        let [a, b, c,d] = [1, 2, 3];
        console.log('[destructuring-array]:', a, b, c,d);

    }
    {
        let [a, [b], c] = [1, [2], [3]];
        console.log('[destructuring-array]:', a, b, c);
    }
    {
        let [, , c] = [1, 2, 3];
        console.log('[destructuring-array]:', c);

    }
    {
        let [,b , ] = [1, 2, 3];
        console.log('[destructuring-array]:', b);

    }
    {
        let [a,b  ] = [1, 2, 3];
        console.log('[destructuring-array]:',a, b);

    }
    // ## 尾巴解构😄
    {
        let [a,...b  ] = [1, 2, 3];
        console.log('[destructuring-array:tail]:',a, b);

    }
    /** ## 解构声明允许指定默认值 */
    {
        let [foo=true] = [];
        console.log('[destruction:default]:', foo);
    }
    /** ## 对象的解构赋值 🐶 */
    {
        let {foo, bar} = {foo:'some-key', bar: 12}
        console.log('[destruction:object]:', foo, bar);
    }
    // 默认值
    {
        let {foo, bar,baz=19} = {foo:'some-key', bar: 12}
        console.log('[destruction:object-default]:', foo, bar,baz);
    }
    {
        let obj = {name:'yiqing',age:18};
        let {name:as_new_var} = obj; // 重命名的感觉
        console.log('[---]:', name); // 空值了 
        console.log('[---]:', as_new_var);
    }

    /** ## 字符串解构 */
    {
        const [a,b, c, ] = 'hello';
        console.log('[destructuring:string]:', a, b, c) ;

        // 取其他字符串对象的属性
        const {length} = 'hello';
        console.log('[destruct-string:attribute]', length);
    }

    /** ## 函数参数解构赋值 */

    {
        const add = function([x,y]){ return x+y; }
        console.log('[destruct-func]:',add([1,4]));
    }
    {
        const add = function([x,y=10]){ return x+y; } // 同时指定默认值
        console.log('[destruct-func]:',add([1]));
        console.log('[destruct-func]:',add([1,20]));
    }

    /** ## 常见用途 */
    {
        let x = 1; let y = 2;
        [x,y] = [y,x]; // 交换变量
        console.log('[destruct-usage]:', x, y);
    }
    {
        // json 
        let jsonData  = {
            id: 42,
            status: 'ok',
            data: [12,34],
        };
        let {id, status, data:items} = jsonData ;
        console.log('[from json]:',id,status, items);
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