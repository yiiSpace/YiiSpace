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
        toString(){
            console.log(`name: ${this.name}, age: ${this.age}`) ;

            console.log(this) ;
        },
        toString2(){
            setTimeout(function(){
                // 这里的this 代表的是window对象哦 ，
                // Node 环境 指向的是 setTimeout 对象 
                console.log(this) ;
            }, 200);
        },
        toString3(){
            setTimeout(()=>{
                // ⚠️ 这里的this 代表的是对象本身哦
                console.log(this) ; 
            }, 200);
        },
        legacyMethod(){
            // 原来的this做法
            let that = this ;
            setTimeout(function(){
                //   this = that ; // 这里不行🙅 哦
                // ⚠️ 这里的this 代表的是? 还是window｜setTimeout 对象
                // console.log(this) ; 
                console.log(that) ; // 只能用that指示this了
            }, 200);
        }
     }
     obj.toString();
     obj.toString2();
     obj.toString3();
     obj.legacyMethod();

   }

   // 箭头函数永远绑定最外面的对象
   {
      let obj = {
        name: 'qing',
        age: 18,
        gender: '男',
        profile: {
            likes: ()=> {
                console.log('[nested obj: user/profile: ]', this.name ) ;
            }
        }
      }
      obj.profile.likes();

      // 这种形式的箭头函数➡️ 从定义开始 this就定下来了 
      let foo = ()=> {
        console.log('[foo is called]:', this) ;
      }

      foo() ;
      obj.profile.likes = foo ;
      obj.profile.likes();

      // 试下bind函数 ，发现bind也不能改变箭头函数的this指向！
      foo.bind(obj) ;
      foo();

      // ⚠️ 注意 这种形式的函数 this会变 
      function foo2(){
        console.log('[foo2 is called]:', this) ;
      }
      foo2();
      obj.profile.likes = foo2 ;
      obj.profile.likes();

      // bind 会导致this指向变化为obj对象的
      foo2.bind(obj);
      foo2();
   }
    
   /**
    * 有空可以看看 bind call apply 的相关知识
    * baidu 随便搜索了一个 可以参考下：https://blog.csdn.net/qq_39148344/article/details/90173640
    */
    
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