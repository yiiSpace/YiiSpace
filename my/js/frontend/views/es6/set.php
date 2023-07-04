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
      let s = new Set() ;
      s.add(1);  
      s.add(1);  
      s.add(2);  
      s.add(2); 
      s.add('some string'); 
      s.add(true); 
      s.add(2.0); 

      console.log(s); 
      console.log(s.size); 
        
    }
    // 用数组来生产
    {
        let arr = [1,2,3,3,3,'hi'] ;
        let s  = new Set(arr) ;

        console.log(s) ;
        console.log(s.size) ;

    }

    // 常用方法
    {
        // 编译器可以自动推断类型了 Set<String|number> 泛型
        let s = new Set([1,2,3,4,5,6,7,8,9,'']) ;
        console.log(s.size) ; 

        s.add(2) ;
        console.log(s.size );
        console.log(s.has(2)) ;
        console.log(s.has('2')) ;

        s.delete(2) ;
        console.log('[set::delete]:',s.has(2)) ;

        // 全清
        s.clear();
        console.log(s) ;
    }

    // 转换
    {
        let s = new Set([1,2,3,4,5,6,7,8,9,'']) ;
        let arr = new Array(...s) ;
        console.log(arr) ;

        let a2  = Array.from(s) ;
        console.log(a2) ;

    }
    // 遍历
    {
        let s = new Set([1,2,3,4,5,6,7,8,9,'']) ;
        
        // 这个没管用么
        for(let i in s){
            console.log('in set:', i) ;
        }
        for(let i of s){
            console.log('of set',i) ;
        }

        s.forEach((k,v,s)=>{
            console.log(k+'_'+v);
        })
    }

    // ## 弱集合 只能添加对象
    /**
     * - 不支持foreach size 相对于Set 有些方法不能用
     * - 跟垃圾收集有关
     * - 跟Node 环境表现不一样！
     */
    {
        try{

            let ws = new WeakSet([1,'2']) ;
            console.log(ws) ;
        }catch(e){
            _alert(e) ;
        }
        let ws = new WeakSet([]);
        ws.add({});
        ws.add({name:'qing'});
        ws.add({name:'qing',age:18});

        console.log(ws);

        let obj = {name:'yiispace'} ;

        ws.add(obj) ;
        console.log(ws);

        console.log(ws.has(obj)) ;
        obj = null;
        console.log(ws);
        console.log(ws.has(obj));
    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> Set 类型和属性 </h4>
    <p>
       ES6之前只有array一种数据结构！！！ 现在添加了 Set和Map 
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