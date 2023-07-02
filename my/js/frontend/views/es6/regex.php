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
      console.log('[正则','--'.repeat(10)) ;

       let match = /吉{2}/.test('吉吉') ;
       console.log(match) ; 
       
       match = /𠮷{2}/.test('𠮷𠮷') ;
       console.log(match) ; 

       match = /𠮷{2}/u.test('𠮷𠮷') ;
       console.log(match) ; 


      console.log('--'.repeat(10),'正则/]') ;
    }

    {
        let text = 'xxx_xx_x_' ;
        let pattern = /x+_/ ;

        console.log(pattern.test(text)) ;
        console.log(pattern.exec(text)) ;
        console.log(pattern.exec(text)) ;
        console.log(pattern.exec(text)) ;

        let pattern2 = /x+_/y ;
        console.log(pattern2.exec(text)) ;
        console.log(pattern2.exec(text)) ;
        console.log(pattern2.exec(text)) ;
        console.log(pattern2.sticky) ; // 是否有粘滞性
        console.log(pattern.sticky) ; //  第一个就没有

        // 返回正则的修饰符
        console.log(pattern2.flags) ;

    }

    // s 修饰符可以匹配\n
    {
        let text = 'xy\nz';
        let patt = /xy.+z/;

        console.log(patt.test(text)) ;

         patt = /xy.+z/s;
         console.log(patt.test(text)) ;
    }
    // 修饰符替换 ，是想搞正则重用么？🤔
    {
        let reg = new RegExp(/xyz/iu);
        console.log(reg.flags) ;

        reg = new RegExp(/xyz/iu,'g');
        console.log(reg.flags) ;

        reg = new RegExp(reg,'iu');
        console.log(reg.flags) ;
    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> 正则的 扩展及改进 </h4>
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