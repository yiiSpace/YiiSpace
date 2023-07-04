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
    
        

    }

    // 展开运算符
    {
        const add = function(x,y){
            return x+y ;
        }

        console.log(add(...[10,20])) ; // ... 将一个数组转化为逗号分隔的值来处理 

        console.log(Math.max(...[10,20,30])); // 求最值
        console.log(...[1,2,3],...[4,5,6,7,8,9]); // 数组合并 

        console.log([[1,2],[3,4]]) ;
        console.log([...[1,2],...[3,4]]) ;
    }

    // ## 方法扩展
    {
        let items = Array(3) ; // 只有一个元素时 参数以数组长度做解析了
        console.log(items) ;


        items = Array(2,3) ;
        console.log(items) ;

        items = Array.of(3) ;
        console.log(items) ;

        items = Array.of(1,2,3) ;
        console.log(items);
    }

    // 类似数组的集合对象转化 对将被转化的对象要求很严格！
    /**
     * 常用的场景
     * 
     * - DOM 的NodeList 集合
     * - Es6 新增的Set 和 Map 
     */

    {
        let obj = {
            0: 'name', // key必须是数字 且需要从0开始
            1: 'age',
            2: 'gender' ,
            10: 'some_value' ,
            length: 3 , // 需在length范围内
        };

        let items = Array.from(obj) ;
        console.log(items) ;

        let eles = document.querySelectorAll('#for_conversion>li');
        console.log(eles) ;

        items = Array.from(eles) ;
        console.log(items) ;
    }

    // 查找
    {
        let count = 0; 
        let items = [1,2,3,4,5,6,7,8,9] ;
        // 查到后就停止 
        item = items.find(val=>{ count++; return val == 7 ;});
        // item = items.find((val, idx, obj)=>{ count++; return val == 7 ;}); // 参数完整形式有三个参数的 我们这里只需要第一个 按值查找即可 
        console.log('[array::find ]:', item) ;
        console.log('[array::find count ]:', count) ;

        console.log('[array::findIndex]: 3在数组中的索引位置是：',items.findIndex(val => val == 3)) ;
        console.log('[array::findIndex]: 第一个大于3在数组中的索引位置是：',items.findIndex(val => val > 3)) ;

    }

    // 填充
    {
       let items = Array(10) ;
       items.fill('a',1,6) ; // 填充a 索引1开始 6 结束

       console.log('[Array::fill]:' ,items) ;
    }

    // 黏贴
    {
        let items = [1,2,3,4,5,6,7] ;
        items.copyWithin(2,0) ; // 从索引0开始一直复制到尾部 然后粘贴到从索引2开始的位置 有点游标卡尺 错位覆盖的感觉
        console.log(items) ;
    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> 数组 扩展及改进 </h4>

    <ul id="for_conversion">
        <li>
            some text1
        </li>
        <li>
            some text2
        </li>
        <li>
            some text3
        </li>
        
    </ul>

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