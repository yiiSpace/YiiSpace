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
        let obj = {
            name: 'qing',
            age: 18,
            gender: 'male',
        };

        let p = new Proxy(obj, {});

        console.log(p.name);

        p = new Proxy(obj, {
            get(target, property) {
                return 'secret...😂！';
            }
        });
        console.log(p.name);
        console.log(p.gender);

        p = new Proxy(obj, {
            get(target, property) {
                if (property === 'age') {
                    return '... 🙅 secret age 🚫 ...';
                } else {
                    return target[property];
                }
            }
        });
        console.log(p.name);
        console.log(p.age);
    }
    // set 方法拦截
    {
        let obj = {
            name: 'qing',
            age: 18,
            gender: 'male',
        };

        let p = new Proxy(obj, {
            set(target, property, value, rcv) {
                if (property === 'age') {
                    if(!Number.isInteger(value)){
                        throw new TypeError('类型错误，年龄需要为整数!') ;
                    }
                    if (value > 35 || value < 18) {
                        // value = 19;
                        throw new TypeError('童工不要 ！ 年龄大的不要！😭') ;
                    }

                }
                target[property] = value;

            }
        });
        p.age = 19 ;
        console.log(p.age) ;
        try{
            p.age = 36 ;
            console.log(p.age) ;

        }catch(e){
            alert(e) ;
        }
    }
</script>
<?php $this->endBlock(); ?>
<?php $this->beginBlock('my-es-code2'); ?>
<script>
    // 简单例子🌰  禁止赋值
    {

        let obj = {
            name: 'qing',
            age: 18,
            gender: 'male',
        };

        let p = new Proxy(obj, {
            set(target, property, value, rcv) {
               
                return false ;
                // target[property] = value;

            }
        });
        p.age = 19 ;

        console.log(obj);
    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> Proxy </h4>
    <p>
        中间人｜经纪人 会隔离目标对象

        客户对目标的访问是通过经纪人进行的 这个中间者可能会做一些额外处理 而不是直接把操作
        传递到目标之上 ， 比如可以做信息验证 值串改 属性屏蔽 虚拟属性 字段保护 ... 日志 

        vue3 就大量用到了代理对象
    </p>

    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3">
                    <a href="#test1" class="active">代理 读写保护</a>
                </li>
                <li class="tab col s3">
                    <a href="#test2">Proxy 禁止赋值</a>
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