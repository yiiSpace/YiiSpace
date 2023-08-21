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
    // setTimeout(()=>{_alert('unicode:'+"\u0061")},500);
    _alert('unicode:' + "\u0061");
    _alert('unicode:' + "\uD842\uDFB7");
    _alert('unicode:' + "\u20BB7", '加大括号后就正确识别了:', "\u{20BB7}");
    _alert('unicode:', "\u{20BB7}", "\u{41}\u{42}\u{43}", "hell\u{6F}", '\u{1F680}' === '\uD83D\uDE80');

    // 6 种方法可以表示一个字符。

    '\z' === 'z' // true
    '\172' === 'z' // true
    '\x7A' === 'z' // true
    '\u007A' === 'z' // true
    '\u{7A}' === 'z'

    /** ## 字符串的遍历器接口 */
    {
        for (let codePoint of 'foo') {
            console.log(codePoint)
        }

        // 码点识别

        let text = String.fromCodePoint(0x20BB7);

        for (let i = 0; i < text.length; i++) {
            console.log(text[i]);
        }
        // " "
        // " "

        // 遍历器最大的优点是可以识别大于0xFFFF的码点
        for (let i of text) {
            console.log(i);
        }
        // "𠮷"

    }

    // ## 直接输入 U+2028 和 U+2029 
    {
        // 
        '中' === '\u4e2d' // true
        /**
         * 五个特殊字符不能在字符串中使用 只能使用转义形式 
         * 
            U+005C：反斜杠（reverse solidus)
            U+000D：回车（carriage return）
            U+2028：行分隔符（line separator）
            U+2029：段分隔符（paragraph separator）
            U+000A：换行符（line feed）
         *   
         * 举例来说，字符串里面不能直接包含反斜杠，一定要转义写成\\或者\u005c。
         */

        const json = '"\u2028"';
        JSON.parse(json); // 可能报错
        const PS = eval("'\u2029'"); // ES2019 不会报错
        /**
         * 注意，模板字符串现在就允许直接输入这两个字符。另外，正则表达式依然不允许直接输入这两个字符，这是没有问题的，
         * 因为 JSON 本来就不允许直接包含正则表达式。
         */

    }
    // ## 模版字符串 template string
    {
        // 普通字符串
        // `In JavaScript '\n' is a line-feed.`

        // 多行字符串
        `In JavaScript this is
 not legal.`

        console.log(`string text line 1
string text line 2`);

        // 字符串中嵌入变量
        let name = "Bob",
            time = "today";
        let result = `Hello ${name}, how are you ${time}?`;
        _alert('result: ', result);

        // 转义
        let greeting = `\`Yo\` World!`;
        _alert('greeting:', greeting);
    }
    // 
    {
        // 嵌入变量 模板字符串中嵌入变量，需要将变量名写在${}之中。
        function authorize(user, action) {
            if (!user.hasPrivilege(action)) {
                throw new Error(
                    // 传统写法为
                    // 'User '
                    // + user.name
                    // + ' is not authorized to do '
                    // + action
                    // + '.'
                    `User ${user.name} is not authorized to do ${action}.`);
            }
        }

        // 大括号内可以放入任意表达式
        let x = 1;
        let y = 2;

        // `${x} + ${y} = ${x + y}`
        // "1 + 2 = 3"

        `${x} + ${y * 2} = ${x + y * 2}`
        // "1 + 4 = 5"

        let obj = {
            x: 1,
            y: 2
        };
        `${obj.x + obj.y}`
        // "3"

        // 调用函数
        function fn() {
            return "Hello World";
        }

        `foo ${fn()} bar`
        // foo Hello World bar

    }
</script>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('my-es-code2'); ?>
<script>
    // 🌰 新增方法
    console.log(String);  
</script>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('my-es-code3'); ?>
<script>
    // 简单例子🌰  
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
                    <a href="#test1" class="active">基础</a>
                </li>
                <li class="tab col s3">
                    <a href="#test2">其他</a>
                </li>


            </ul>
        </div>
        <!-- tab-pannel  -->
        <div id="test1" class="col s12">

            <pre>
            <code class="language-js">
                <?= \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code'])  ?>
                </code>
            </pre>

        </div>
        <!-- tab-pannel  -->
        <div id="test2" class="col s12">
            <pre>
            <code class="language-js">
                <?= \year\widgets\JsBlock::stripScriptTag($this->blocks['my-es-code2'])  ?>
                </code>
            </pre>
        </div>


    </div>

</div>

<?php \year\widgets\JsBlock::begin() ?>
<script>
    /**
     * _alert(...msg) 也可以
     */
    function _alert(msg) {
        // ⚠️箭头函数不绑定 arguments！
        // arguments的callee属性 表示函数本身！ callee.length表示的是形式参数数目 不一定等于arguments.length
        const args = Array.prototype.slice.call(arguments, 0);
        //    console.log(args); // 可以👀到Array的方法
        //    const args = Array.from(arguments) ; // ES6之后支持 [...arguments] 也可以！
        msg = args.join(' ');
        M.toast({
            text: msg,
            classes: 'rounded'
        });
    }
</script>
<?= $this->blocks['my-es-code'] ?>
<?= $this->blocks['my-es-code2'] ?>
<?= $this->blocks['my-es-code3'] ?>
<?php \year\widgets\JsBlock::end() ?>

<?php \year\widgets\JsBlock::begin() ?>
<script>
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