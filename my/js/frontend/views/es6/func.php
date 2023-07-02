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
   
   function printUserInfo(name, age=18, addresses= [], options={}, cb=()=>{}){
        console.log('[user-info]:',name, age, addresses,options , cb) ;
   }

   

   {
        let userInfo = {
            name: 'qing',
            age: 13,
        };
        printUserInfo(userInfo.name) ;
   }
   // 😂 啥东西呀 不运行
   {
        class User{
            name;
            age ;
            gender ;
           
              construct(name, age, options= function(user){}){
                this.name = name ;
                this.age = age ;

                options(this) ;
            }

             toString(){
                console.log( '[user]:' ,this.name, this.age, this.gender)
            }
        }
        let user = new User('qing',18) ;
        console.log(user.toString()) ;
   }

   // 默认值是函数调用
    //  let pi = ()=> 3.14 ;
    function pi(){
        return 3.14;
    }

    //  let area = function(r, pi=pi()){ // pi 不可同名🙅
      function area(r, p=pi()){
       return  p* r* r ;
     }

     console.log(area(2)) ;

     {
        // 默认值位置在前面
        let fn_foo = function(name='qing', age){
            console.log('[foo]:', name, age) ;
        }

        fn_foo(undefined, 18) ; // 只能用undefined 占位 其他不行哦🙅‍♂️ null|'' 都不行哦
        fn_foo(null, 18) ;
        fn_foo('', 18) ;
     }

     // 使用前面的参数作为后面参数的默认值
     {
        let fn_bar = function(w, h=w){
            console.log('[bar]:', `width: ${w}, height: ${h}`);
        };

        fn_bar(560) ;
     }

     //  variadic function arguments
     {
        let fn_foo = function(name , ...others){
           console.log('[variadic args]:',name, others) 
        }

        fn_foo('qing',28,'男','xian');
        fn_foo('qing2',18,'男','beijing');
     }

     // 函数的name属性
     {
        function fn(){}
        let fn2 = function(){}
        let obj = {
            fn3: function(){

            }
        };
        console.log('[name property of function]:', fn.name,fn2.name, obj.fn3.name);

        // 匿名函数
        console.log((new Function()).name)

        // 里面访问不到😯
        let foo = function(){
            console.log(this) ;
            console.log(this.name) ;
        }
        foo();
        function foo2(){
            console.log(this) ;
            console.log(this.name) ;
        }
        foo2();
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