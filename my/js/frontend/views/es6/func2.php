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
     let f1 = ()=>{};
     let f2 = (p)=>p ;
     let f3 = p=>p ;

     console.log('[arror-function]:', f2('some-param'));
     console.log('[arror-function]:', f3('some-param'));

   }
   // 
   {
     let sum = (a,b)=> a+b ;
     console.log('[arror-func:sum]:', sum(1,2));
   }
   // 不需要参数
   {
    let giveMeFive = ()=> 5 ;
    console.log('[giveMeFive]:', giveMeFive()) ;
   }
   // 函数体较复杂
   {
        let logSum = (a,b)=> {
            console.log('sogSum is called , and params is :', a, b);
            let result = a+b ;
            console.log('logSum result is :', result) ;
            return result ;
        }

        logSum(5, 6) ;
   }

   // 返回对象
   {
        let fn = name  => ({name, age:18, city: 'beijing'});

        console.log('[return obj]：', fn('qing')) ;
        console.log('[return obj]：', fn('qiang').name) ;
   }

   // 对象做参数 解构？
   {
        let fn = ({name}) => `object name is ${name}` ;

        console.log('[obj-as-params]:', fn({name:'qing', age: 18})) ;
        console.log('[obj-as-params]:', fn(fn)) ; // ⚠️注意 fn也有名字哦😯

   }

   // 立即执行函数 ｜ 即时函数
   {
      // 步骤: 1 先两个括号 2，后面的括号传递参数 3，前面括号里面写函数定义
      // ()(); => ()('some_param'); => (p=>{console.log(p)})('param');

       ((p)=>console.log('hi:', p))('qing');
   }
   
    
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> 箭头函数 和 this </h4>
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