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

    // 解构： 数组 与 对象
    let info = ['qing', 18, '男'];
    let [name, age, gender] = info; // 类比rust ；php中的 list 
    console.log(name, age, gender);

    {
        let info = ['qing', 28, '男'],
         [name, age, gender] = info; // 省一些输入 合并声明
        console.log(name, age, gender);

    }
    // 深层次也可以
    {
        let [name, [age, gender]] = ['qing', [28, '男']]; // 省一些输入 合并声明
        console.log('[nested]:',name, age, gender);
    }

    // 可以忽略一些成员 但结构仍需契合
    {
        let [name, ,  ] = ['qing', [28, '男'] , 'some addr']; // 省一些输入 合并声明
        console.log('[ignore]:',name );
    }

    // 不存在则赋予默认值
    {
        let [name, addr='地球上'] = ['qing'] ;
        console.log('[destruction-default-value]:', name, addr) ;
    }

    // 批量解构 expand 扩展表达符： ...
    {
        let [name, ...others] = ['qing','男','china' ,'it'];
        console.log(name, others) ;

    }

    // ## 对象的解构
    {
        // 字面量解构
        let {name, age} = {name: 'qing', age: 28} ;

        console.log('[literal-destruction]:', name, age) ;
    }
   {
       let userInfo = {
           name: 'qing',
           age: 18,
           gender: '男',
       };
       let {name , gender} = userInfo ;
       console.log('[obj-destruction]:', name, gender) ; 

       let print_user = function({name, gender}){
        console.log('[fn print_user]:', name, gender) ;
       }

       print_user(userInfo) ;

       // 这啥东东?
       ({name, age} = userInfo) ;

   }
   // 默认值
   {
    let userInfo = {
           name: 'qing',
           age: 18,
           gender: '男',
       };

      let {name, addr='地球上'} = userInfo ;
      
      console.log('[obj-destruction-default-value]:',name, addr) ;

   }
   // 重解构重命名
   {
    let userInfo = {
           name: 'qing',
           age: 18,
           gender: '男',
       };
    let {name: my_name, age} = userInfo  ;

    console.log('[destructionn-rename-member]:' , my_name, age) ;
   }
   // 嵌套情况
   {
    let userInfo = {
           name: 'qing',
           age: 18,
           gender: '男',
           addresses: [
             'beijing',
             '上海',
             '广州',
           ]
       };

       // 这里地址只要了前两个！ 并且 addresses失效！ 类似树中只有叶子节点是有效的那样
       let {name,addresses:[first_city,second_city] } = userInfo ;
       console.log('[obj-nested:]:', name,'工作于：', first_city,second_city) ;
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