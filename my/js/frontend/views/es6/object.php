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
    // 简单例子🌰 属性 简写方案
    {
        let objFactory = function(name, age) {
            return {
                name: name,
                age: age,
            };
        };
        console.log('[obj-creator]:', objFactory('yiqing', 18));

        let objCreator = function(name, age) {
            return {
                name,
                age,
            }
        };

        console.log('[obj-creator]:', objCreator('yiqing', 28));


    }

    // 方法的简写
    {
        let obj = {
            name: 'yiqing',
            age: 18,
            userInfo: function() {
                return `user ${this.name} is ${this.age} year old`;
            }
        };
        console.log('[user info]', obj.userInfo());

        // 简写 新语法
        obj = {
            name: 'yiqing',
            age: 18,
            userInfo() {
                return `user ${this.name} is ${this.age} year old`;
            }
        };
        console.log('[user info]', obj.userInfo());
    }

    // 表达式
    {
        let obj = {
            ['user' + 'Name']: 'yiqing',

            // 属性含有空格
            ['user ' + 'Age']: 28, // 这种情况只能用数组索引方式访问

            'some key': 'some-value',
        };
        console.log('[obj attr expr]:', obj.userName);
        console.log('[obj attr expr]:', obj['userName']);
        console.log('[obj attr expr]:', obj['user Age']);
        console.log('[obj attr expr]:', obj['some key']);
    }

    {
        let nameAttr = 'name';
        let obj = {
            name: 'qing',
        };

        console.log(obj[nameAttr]);

        obj = {
            [nameAttr]: 'qing',
        };

        console.log(obj[nameAttr]);

    }
    // 函数情况
    {
        let fnName = 'hi';
        let obj = {
            [fnName]() {
                return fnName + ' is called';
            }
        };
        console.log(obj[fnName]());
        console.log(obj.hi());
    }

    // ## 新增方法
    {
        console.log(Object.is(2, '2')); // 判断相等
        console.log(Object.is({}, {})); // 判断对象地址相等

        console.log(+0 === -0); //
        console.log(Object.is(+0, -0)); //

        console.log(NaN === NaN); //
        console.log(Object.is(NaN, NaN)); //
    }
    // 对象合并
    {
        // 跟JQuery 的 $.extend()  有点像哦
        console.log(Object.assign({}, {
            name: 'qing'
        }, {
            age: 18
        }));

        let obj = {
            name: 'qing',
            age: 18
        };
        let obj2 = {
            name: 'qing',
            age: 28
        };
        let obj3 = {
            gender: '男'
        };

        Object.assign(obj, obj2, obj3); // 属性相同则后者覆盖前者 属性没有就新增
        console.log(obj); // obj是被修改者 后面的对象是只读了
        console.log(obj2); //
        console.log(obj3);


        console.log(Object.assign({}, ['hi'])); // 非对象会被转化为对象
        console.log(Object.assign({}, undefined));
        console.log(Object.assign({}, null));
    }

    // prototype 原型链相关
    {
        let obj = {
            fn() {
                return 'obj.fn is called';
            }
        };
        let obj2 = {
            fn() {
                return 'obj2.fn is called';
            }
        };

        let o = Object.create(obj);
        console.log(o.fn());
        // 获取原型链
        console.log(Object.getPrototypeOf(o) === obj);

        // 更换原型
        Object.setPrototypeOf(o, obj2);
        console.log(o.fn());
        console.log(Object.getPrototypeOf(o) === obj);
        console.log(Object.getPrototypeOf(o) === obj2);

    }
    // super
    {
        let obj0 = {
            fn() {
                return 'obj0.fn is called';
            }
        };
        let obj1 = {
            fn() {
                return 'obj1.fn is called';
            }
        };
        let obj = {
            fn() {
                return super.fn() + ' is extended';
            }
        }

        // console.log(obj.fn()) ; // 还不能调用呢
        Object.setPrototypeOf(obj, obj0); // 有点动态替换父亲的感觉 
        console.log(obj.fn()); // 

        Object.setPrototypeOf(obj, obj1);
        console.log(obj.fn()); //

        let obj3 = Object.create(obj);
        console.log(obj3.fn()); //

        console.log(Object.getPrototypeOf(obj3) === obj);
        // 原型链形成啦
        console.log(Object.getPrototypeOf(Object.getPrototypeOf(obj3)) === obj1);
    }
</script>
<?php $this->endBlock(); ?>


<div class="js-es6-index">
    <? // ViewInfo::widget(); 
    ?>
    <h4> 对象 扩展及改进 </h4>

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