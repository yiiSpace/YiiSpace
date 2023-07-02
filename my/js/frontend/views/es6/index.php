<?php
use common\widgets\ViewInfo;
use macgyer\yii2materializecss\widgets\Modal;

/**   @var \yii\web\View $this  /
/**    @var string $content  */

// 注册js｜css 所需的asset

$asset =\common\widgets\PrismAsset::register($this);
// 手动加载插件的代码示例
// $cdnUrl = $asset->getCDNUrl();
// $pluginJs = $cdnUrl.'/plugins/autoloader/prism-autoloader.min.js';

// array_push($asset->js,$pluginJs) ; 



  Modal::begin([
       'closeButton' => [
            'label' => 'Close modal',
            'tag' => 'span'
        ],
       'toggleButton' => [
            'label' => 'Open modal'
        ],
        'modalType' => Modal::TYPE_LEAN,
   ]);
  
   echo 'Say hello...';
  
   Modal::end();
   
   ?>



 <?php $this->beginBlock('my-es-code'); ?>
 <script>
    function _alert(msg){
        M.toast({text: msg, classes: 'rounded'});
    }

    M.toast({text: 'I am a toastd! just for test', classes: 'rounded'});

    // console.log(some_value_not_defined) // ⚠️注意跟 undefined的区别 定义了 但未初始化就是undefined
    console.log(value); // 可以后向访问！ 看👀控制台输出！
{
    var value = 10 ; // var 有变量提升能力 均视为作用域顶部声明
    let count = 20 ;

}
console.log(value);
// console.log(count) ; // ⚠️ 出现错误后 会导致左侧菜单有些功能异常 count 出作用域块后就不能再被访问


try{
    
    console.log(not_defined_let_var);
    console.log(defined_let_var);
    let defined_let_var ; // 只不过没有初始化
}catch(e){
    M.toast({text: e.toString(), classes: 'rounded'});
    console.log(String(e));  // String() 函数返回与字符串对象的toString()方法值一样。
    // JSON.stringify() 也可以对像转数组 配对函数 parse 可以反向转化
}

try{
    if(true){
        console.log(typeof value);
        // TDZ 临时性死区
        value = 10 ; //  这里不声明 直接赋值也不会报错
        console.log(value) ;

        let value ; // 这里声明下就出问题啦！
    }
}catch(e){
    _alert(e)
}
try{

        let value ;  
        // let value ; // 重复声明
        // var value ;    // 还算重复声明

        var v1 ;
        var v1 ;
        var v1 = 10 ; // var重复声明 后者替代前者
   
}catch(e){
    _alert(e)
}

{
    let value = 0 ;
    {
        // _alert(value) ; // 这里访问value 就会出错的！
        let value = 10 ; // 不同作用域下 内层可以跟外层同名

        _alert(value) ;
    }
    _alert(value) ;
}

// ============= 循环 loop ♻️
for(let i = 0; i<10 ; i++)
{
    console.log(i);
}
console.log(i); // 这里不能再访问了！

for(var i = 0; i<10 ; i++)
{
    console.log(i);
}
console.log(i); // 这里可以再访问了！

// 😄 
var list = [] ;
// for 中 var  改let 就不同结果
for(var i = 0 ; i< 10 ; i++)
{
    list[i] = function(){
        console.log('list fn: ',i) ;
    };
}
list[3]() ; // 小心👀 这里打印的是10哦

var list = [] ;
//  同👆上面比较下
for(let i = 0 ; i< 10 ; i++)
{
    list[i] = function(){
        console.log('list fn: ',i) ;
    };
}
list[3]() ; // 小心👀 这里打印的是3

// ===== const 

const PI = 3.1415926 ; // 声明同时必须赋值 初始化
// try{
//     const PI2 ; // 直接就是语法错误了
// }catch(e){
//     _alert(e);
// }

</script>
 <?php $this->endBlock(); ?>



<div class="js-es6-index">
<? // ViewInfo::widget(); ?>

    <div>
    <pre><code class="language-js">
    <?=  \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code'])  ?>
    </code></pre>
    </div>

    <button type="button" class="btn" onclick="M.toast({text: 'I am a toast', completeCallback: function(){alert('Your toast was dismissed')}})">Toast!</button>
</div>


<?php \year\widgets\JsBlock::begin() ?>

<?= $this->blocks['my-es-code'] ?>

<?php \year\widgets\JsBlock::end() ?>


<?php \year\widgets\CssBlock::begin() ?>
<style>
   
</style>
<?php \year\widgets\CssBlock::end() ?>