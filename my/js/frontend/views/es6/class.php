<?php

use common\widgets\ViewInfo;
use macgyer\yii2materializecss\widgets\Modal;
use yii\helpers\Inflector;

/**   @var \yii\web\View $this  /
/**    @var string $content  */

// 注册js｜css 所需的asset
$asset = \common\widgets\PrismAsset::register($this);
?>

<?php $this->beginBlock('my-es-code'); ?>
<script>
    // 简单例子🌰  
    {
       class User{
        // 构造器
        constructor(name){
            this.name = name;
        }

        // 普通方法
        run(){
            console.log ('[User::run]: ',  this.name) ;
        }
       }
        
       let u = new User('qing') ;
       u.run() ;
       // access the property of User class
       console.log(u.name) ;

       // 判断
       console.log(u instanceof User) ;
       console.log(typeof User) ;
    }

    // ## getter && setter
    {
        class User{
            constructor(name='default'){
                this._name = name ;
            }

            get name(){
                return this._name ;
            }
            set name(value){
                console.log('[before setter name] ') ;
                this._name = value ;
                console.log('[after setter name] ') ;
            }
        }

        let u = new User('qing') ;
        // console.log(u.name()) ;
        console.log('[getter is called]: ',u.name) ;
        console.log('[getter-setter]: ', u) ;

        u.name = 'qiang' ;

        console.log('[getter-orig-attribute]:', u._name) ;
    }
</script>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('my-es-code2'); ?>
<script>
    // 简单例子🌰  
    {
      let Usr = class User{
         constructor(name='unknown'){
            this.name = name ;
         }
      }

      let u = new Usr() ;
      console.log(u) ;

    //   u = new User() ; // 不能再用User创造对象了
      console.log(u) ;
        
    }
    //
    {
        let User = class{
            constructor(name='default-name'){
                this.name = name ;
            }
        }

        let u = new User();
        console.log(u) ;
    }
    // 
    {
        let u = new class{
            constructor(name='default-name'){
                this.name = name ;
            }
        }('qing');
        console.log(u) ;
    }
</script>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('my-es-code3'); ?>
<script>
    // 简单例子🌰  
    {
      let Usr = class User{
         constructor(name='unknown'){
            this.name = name ;
         }

         run(){
            console.log('I am a User and my name is :', this.name) ;

            return 'some result from user class' ;
         }
      }

      let u = new Usr() ;
      console.log(u) ;

      class Women extends Usr{
        title(){
            return 'Miss. ' + this.name ;
        }
      }
   
      let w = new Women('qing');
      console.log(w.title()) ;
      console.log('[instanceof Women]: ', w instanceof Women) ;
      console.log('[instanceof Usr]:',w instanceof Usr) ;

      let users = [] ; // ts 情况可以强制约束类型

      users.push(new Usr()) ;
      users.push(new Women('Han-meimei')) ;

      for(let u of users){
         console.log(u.name) ;
      }

      // 调用父类方
      class Man extends Usr{
        constructor(name,options={}){ 
            super(name ); 
            this.options = options ;
            console.log('[constructor of Man and other options is ]:', options);
        }

        // 子类复写父类同名方法 一般做环绕(before/after around) 或者对父类的返回值做增删改 比如网络编程中 对Header头的操作
        run(){

            let result = super.run() ;
            console.log('[and I am a Man]:', this.options);
            result = result.replace('user','USER');
            return result ;
        }
      }
      let m = new Man('qing',{'hobby':'game|swim|ride|climbing'});
      console.log(m) ;
      let result =  m.run();
      console.log(result) ;

      // 原型父类判断
    //   console.log('[Parent class of Man is Usr? ]', Object.getPrototypeOf(m) === Usr) ;
      console.log('[Parent class of Man is Usr? ]', Object.getPrototypeOf(Man) === Usr) ;
    }
    // 静态方法
    {
        class User{
            static GENDER = '...' ;
            static COUNT = 0 ;

            constructor(){
                User.COUNT += 1 ;

            }

           static run(){
                console.log('user gender is ', User.GENDER) ;
            }

            static info(){
                // 如果使用this 具有动态后期绑定的特点 如果使用了类名 那就绑死到类上了 ⚠️
                console.log('class User : gender is ', this.GENDER,' and count is : ',this.COUNT) ;
            }
        }
        class Man extends User{
            static GENDER = '男' ;

            foo()
            {
               console.log('my gender is ',  this.GENDER );
            }
            static bar(){
                console.log('my gender is ',  this.GENDER );
            }
        }

        new User();
        new User();
        new User();
        new User();
        let m = new Man();
        // ⚠️ foo跟bar 两个方法的区别 this 真诡异
        m.foo();
        Man.bar();

        console.log(User.COUNT) ;
       // ⚠️下面👇两个方法特点 有继承的意味
        User.info();
        Man.info();
    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> <?= Inflector::camelize($this->context->action->id) ?> </h4>

    <p>

    </p>

    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3">
                    <a href="#test1" class="active">类 基础</a>
                </li>
                <li class="tab col s3">
                    <a href="#test2">其他</a>
                </li>
                <li class="tab col s3">
                    <a href="#test3">继承</a>
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

        <div id="test3" class="col s12">
            <pre>
            <code class="language-js">
                <?= \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code3'])  ?>
                </code>
            </pre>
        </div>

    </div>



</div>


<?php \year\widgets\JsBlock::begin() ?>
<?= $this->blocks['my-es-code'] ?>
<?= $this->blocks['my-es-code2'] ?>
<?= $this->blocks['my-es-code3'] ?>
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