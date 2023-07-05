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
            let result = (() => {
                // Math.floor((Math.random()*10)+1) > 5; 
                return getRndInteger(1, 10) > 5;
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
            .catch((reason) => {
                console.log('[promise-error]:', reason);
            });

        p.then((value) => {
            console.log(value);
        }, (reason) => {
            console.log(reason);
        });
    }

    // 模拟异步通信
    {
        setTimeout(() => {
            console.log('异步调用结束1');
        }, 3800);
        setTimeout(() => {
            console.log('异步调用结束2');
        }, 800);
        setTimeout(() => {
            console.log('异步调用结束3');
        }, 1800);

        // ===
        let p1 = new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve('异步1');
            }, 3800);
        });
        let p2 = new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve('异步2');
            }, 800);
        });
        let p3 = new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve('异步3');
            }, 800);
        });

        p1.then((result) => {
            console.log(result);

            return p2;
        }).then((result) => {
            console.log(result);
            return p3;
        }).then((result) => {
            console.log(result);
        });
    }

    /**
     * @see https://www.runoob.com/jsref/jsref-random.html
     * 以下函数返回 min（包含）～ max（包含）之间的数字：
     */
    function getRndInteger(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
</script>
<?php $this->endBlock(); ?>
<?php $this->beginBlock('my-es-code2'); ?>
<script>
    // 简单例子🌰  
    {
        let p1 = new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve('异步1');
            }, 3800);
        });
        let p2 = new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve('异步2');
            }, 800);
        });
        let p3 = new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve('异步3');
            }, 800);
        });

        console.log('[promise-state]:' , p1) ;

        p1.then((result) => {
            console.log(result);

            console.log('[promise-state]:' , p1) ;

            return p2;
        }).then((result) => {
            console.log(result);
            return p3;
        }).then((result) => {
            console.log(result);
        });

        // 助手函数
        let p = Promise.all([p1,p2,p3]) ;
        p.then(value=>{
            console.log(value) ;
        });

        // 竞争
        p = Promise.race([p1,p2,p3]) ;
        p.then(value=>{
            console.log('[promise-race]: ', value) ;
        }) ;

        // 助手函数 快速包装
        p = Promise.resolve('my-value') ;
        console.log('[typeof-promise]' , typeof p) ;
        p.then(val=>{
           console.log('[promise-resolve]: ', val) ; 
        });

        let someAsyncOp  = function(context ={cond: true}){
            if(context.cond){
                // 如果条件满足则进行异步动作
                // setTimeout(()=>{
                    
                // },1500) ;
                return new Promise((resolve)=>{
                    resolve('some-remote-data') ;
                });

            }else{
                return Promise.resolve('cached-data') ;
            }
        };

        someAsyncOp({cond:false}).then(value=>{
            console.log('[someAsyncOp]:', value) ;
        });
        someAsyncOp({cond:true}).then(value=>{
            console.log('[someAsyncOp]:', value) ;
        });
    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> Promise </h4>
    <p>

    </p>

    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3">
                    <a href="#test1" class="active">异步Promise</a>
                </li>
                <li class="tab col s3">
                    <a href="#test2">Promise 状态特点</a>
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