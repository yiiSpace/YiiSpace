<?php


?>

<code class="php">
<?= $code ?>
</code>

<pre><code class="js">
    <script>
            var some = 'hi' ;
        </script>
</code></pre>

<?php \year\widgets\HighLightJsAsset::register($this); ?>

<?php \year\widgets\JsBeautifyAsset::register($this) ?>

<?php \year\widgets\JsBlock::begin() ?>
<script>
    $(function () {

        $('code').each(function () {
            // console.log(this);
            $(this).text(js_beautify($(this).text()));

        });
        $('code').wrap('<pre></pre>');

         
        //  // 代码高亮
        //  hljs.configure({useBR: true});
        //  $('code').each(function (i, block) {
        //     hljs.highlightBlock(block);

        //  });
         
         hljs.highlightAll();
    });
</script>
<?php \year\widgets\JsBlock::end() ?>