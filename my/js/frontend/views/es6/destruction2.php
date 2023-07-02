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
    function _alert(msg) {
        M.toast({
            text: msg,
            classes: 'rounded'
        });
    }

    {
        let k = 'qing' , v = 28;
        [k,v] = [v, k] ;
        console.log('[swap-value:]' , k, v) ;
    }

    // 解构函数返回 跟函数参数
    {
        let userInfo = {
            name: 'qing',
            age: 18 ,
            gender: '男',

        };

        let doubleUserAge =  function({name, age}){
            return {
                name,
                age: age*2 ,
            }
        }

       let {age} = doubleUserAge(userInfo) ;

       console.log('[destruction-func-return]:', age);

    }

    // ## 其他类型的解构
    {
        let s = 'ABC' ;
        let [x,y, z] = 'ABC' ;
        console.log('[string-destruction-as-array]: ', x, y, z) ;

        let {length}  = s ;
        // s.length
        console.log('[string-destruction-as-object]: ' , length) ;
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


<?php \year\widgets\CssBlock::begin() ?>
<style>

</style>
<?php \year\widgets\CssBlock::end() ?>