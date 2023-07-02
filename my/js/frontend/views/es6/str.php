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
        let simple = (text = '𠮷') => {
           
            console.log({
                len: text.length,
                'charAt': text.charAt(0),
                'charCodeAt': text.charCodeAt(0),
                'charCodeAt1': text.charCodeAt(1),
                'codePointAt': text.codePointAt(0), // 码点
                'fromCodePoint': String.fromCodePoint(134071), // 吉的异体字
            });
        }

        let text = '吉';
        simple();
        simple(text);
    }

    // 音标
    {
        console.log('\u01D1') ;
        console.log('\u004F') ;
        console.log('\u030C ') ;
        console.log('\u004F\u030C') ; // 组合
        console.log('\u004F\u030C' == '\u01D1') ; // 对比 不是一个东西了
        console.log('\u004F\u030C'.normalize() == '\u01D1'.normalize()) ; // 统一化后再对比
    }

    // 常用的几个方法
    {
        let  text = 'hello qing';
        console.log(text.includes('hello')) ;
        console.log(text.includes('qing')) ;
        console.log('[includes-position]:', text.includes('qing',7)) ;
        console.log('[includes-position]:', text.includes('qing',6)) ;

        console.log(text.startsWith('hello'));
        console.log(text.endsWith('hello'));
        console.log(text.endsWith('qing'));
    }

    // 重复字符串
    {
        
        console.log('<repeat', '=='.repeat(10),' begin ') ;

        console.log('x'.repeat(10)) ;
        console.log('xyz'.repeat(10)) ;
        console.log('xyz'.repeat(0)) ;
        
        // 前后补全 这种函数常用在开发协议上 补全包大小？
        console.log('x'.padStart(5,'0')) ;
        console.log('x'.padEnd(5,'N')) ;

        console.log( '=='.repeat(10),' end />') ;
    }

    // template string
    {
        let name = 'qing',
            age = 18 ,
            text = 'i am '+name+' and my age is '+ age ;

            console.log(text) ;

        let text2 = ` i am ${name} and my age is ${age}`; 
        console.log(text2) ;

        // 模版中的运算
        console.log(` ${1+1}`) ;

        // 嵌套
        let flag = true ;
        text = ` result: ${flag ? 'true' : 'false'}  ` ;
        console.log(text) ;

        text = ` result: ${ flag? `${1+1}` : 3  } ` ;
        console.log(text) ;

        // 🦝 好奇怪的语法：😂
        text = String.raw `我\n 是` ;
        console.log(text) ;

    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> 字符串扩展及改进 </h4>
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