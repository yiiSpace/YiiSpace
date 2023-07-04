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
            // 一些异步操作之后
            let result = (()=>{
                // Math.floor((Math.random()*10)+1) > 5; 
              return  getRndInteger(1,10) >5 ;
                // console.log(getRndInteger(1,10)) ;
            })();

            if (result == true) {
                resolve('some-result');
            } else {
                reject('some-error');
            }
        });

        p.then((value) => {
            console.log(value);
        })
        .catch((reason)=>{
            console.log('[promise-error]:', reason) ;
        });

        p.then((value) => {
            console.log(value);
        },(reason)=>{
            console.log(reason);
        });
    }

    // 模拟异步通信
    {
        setTimeout(()=>{
            console.log('异步调用结束1');
        },3800);
        setTimeout(()=>{
            console.log('异步调用结束2');
        },800);
        setTimeout(()=>{
            console.log('异步调用结束3');
        },1800);

        // ===
        let p1 = new Promise((resolve, reject) => {
            setTimeout(()=>{
                resolve('异步1');
            },3800);
        });
        let p2 = new Promise((resolve, reject) => {
            setTimeout(()=>{
                resolve('异步2');
            },800);
        });
        let p3 = new Promise((resolve, reject) => {
            setTimeout(()=>{
                resolve('异步3');
            },800);
        });

        p1.then((result)=>{
            console.log(result);

            return p2 ;
        }).then((result)=>{
            console.log(result);
            return p3 ;
        }).then((result)=>{
            console.log(result);
        });
    }

/**
 * @see https://www.runoob.com/jsref/jsref-random.html
 * 以下函数返回 min（包含）～ max（包含）之间的数字：
 */
function getRndInteger(min, max) {
  return Math.floor(Math.random() * (max - min + 1) ) + min;
}

</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> Promise </h4>
    <p>

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