<div class="test-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>

    <div class='marquee' data-duration='5000' data-gap='10' data-duplicated='true' >
        Lorem ipsum dolor sit amet, consectetur adipiscing elit END.
    </div>


</div>

<?php \year\widgets\marquee\JMarqueeAsset::register($this) ?>

<?php \year\widgets\CssBlock::begin() ?>
<style>
    .marquee {
        width: 300px; /* the plugin works for responsive layouts so width is not necessary */
        overflow: hidden;
        border:1px solid #ccc;
    }
</style>
<?php \year\widgets\CssBlock::end() ?>

<?php \year\widgets\JsBlock::begin() ?>
<script>
    /**
     * Example of starting a plugin with options.
     * I am just passing some of the options in the following example.
     * you can also start the plugin using $('.marquee').marquee(); with defaults
     */
    $('.marquee').marquee({
        //duration in milliseconds of the marquee
        duration: 15000,
        //gap in pixels between the tickers
        gap: 50,
        //time in milliseconds before the marquee will start animating
        delayBeforeStart: 0,
        //'left' or 'right'
        direction: 'left',
        //true or false - should the marquee be duplicated to show an effect of continues flow
        duplicated: true
    });
</script>
<?php \year\widgets\JsBlock::end() ?>
