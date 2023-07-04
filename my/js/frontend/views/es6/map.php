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
      let m = new Map();
      m.set('name','qing');
      m.set('age',18);

      console.log(m);

      console.log(m.get('name'));

      m.set('age',28);
      console.log(m.get('age'));
        
      console.log(m.size);
      m.forEach((v,k,m)=>{
        console.log('map: ',k,'=>',v) ;
      });
    }

    {
        let m  = new Map([
         [ 'name' ,'qing'], 
         [ 'age' ,18], 
        ]);

        console.log('map: ',m); 

        console.log('map:has: ', m.has('name'));

        m.delete('name');
        console.log('map:has: ', m.has('name'));

        m.clear();
        console.log('map:size: ', m.size);

    }

    // 试试强类型引用问题
    {
        let key = {'name':'qing'} ;
        let value = {'name':'yiispace'};

        let m = new Map() ;

        m.set(key, value);
        console.log( '[strong-map]:',m ) ;

        key = null ;
        console.log( '[strong-map]:' ,m) ;

    }

    // 弱引用Map ; 类似WeakSet 也只能放对象 不用担心gc
    // 键被回收 那么对应的设置值也就没有了  有点附属品的意思 主实体对象咋发展是可以当weakXxx不存在一样 弱Map就跟黑暗影子一样

    /**
     * - 没有foreach 方法 不能遍历！
     * 
     * vue3 使用弱引用set做属性变更通知实现
     */
    {
        let wm = new WeakMap();
        let key = {'name':'qing'};
        let obj = {'age':24};

        // let key = obj;
        wm.set(key, obj);

        console.log('[weakmap]:', wm.get(key));

        key = null ;

        console.log('[weakmap]:', wm.get(key));

        console.log('[weakmap]:', wm);

        (function(){
            let key = {id: 1} ;
            wm.set(key,{
                name: 'qing',
                age: 18 ,
            });
        })(); // 出作用域了 key就被回收♻️了 对应的这条记录也就没有了么 至少没办法再访问到 因为key没有了！   

        //weakMap 没有大小获取的方法 不能遍历 ！
    }
    /**
     * 根据以往 弱引用 强引用的概念 强引用会导致计数器增加 添加到map中就+1
     * 弱引用的话 忽略计数器    那么当对象的引用计数变为0时就被垃圾回收器收回了
     * 
     * 也即意味着 弱引用 WeakMap中的key失效了 没办法再访问到了（即使存在）但这条记录是不是会被自动删除？
     */

</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> Map  类型和属性 </h4>
    <p>
       ES6之前只有array一种数据结构！！！ 现在添加了 Set和Map 

       Map对象可以用dom对象或者其他对象作为key哦😯

       在DDD 领域驱动设计中 

       有Value 值对象的概念 它是依附于领域对象的 没有id 感觉跟弱Map很像 主体被干掉了
       附属体自动消亡 美国死了 两只狗 小鬼子跟韩国自然就挂了

       在事件机制上 很多事件处理器都挂载在主体上 主体被消失 事件处理集合自然没有存在的意义
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