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
     let arr1 = [1,3,2].sort(function(a,b){ return a-b;  });
     console.log(arr1) ;

     // 箭头函数

     let arr2 = [1,3,2].sort((a,b)=> a-b) ;
     console.log(arr2) ;
   }

   // 箭头函数不支持arguments
   {
    let fn = (...others)=>{
        return others[0]+others[1] ; // 忽略第三个及其以后的参数
    }
    console.log('[call fn]:', fn(1,3,4,5)) ;

   }

   // typeof | instanceof 验证
   {
        let fx = ()=>{} ;

        console.log('typeof fx is ', typeof fx) ;
        console .log('instanceof Function: ', fx instanceof Function) ;
   }

   // 尾调用
   {
     let go = (x)=>{
        return x + 1 ;
     }

     let fn = function(x){
        return go(x) ;
     }
     console.log('[tail call]:', fn(2)) ;

     {
        'use strict'
        // 局部👆 开启严格模式 😂 好像不管用呢

        function rec_fn(x){
            if(x <= 1){
                return 1 ;
            }
            return rec_fn(x-1) ; // 尾递归
        }

        console.log('[rec-tail-fn-call]:',  rec_fn(10)) ;

        let public = 2 ; // 严格模式下 关键字 不能作为变量名哦😯
     }
   }
    
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> 箭头函数扩展和尾调用 </h4>
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