<?php
//  @see https://www.w3.org/TR/DOM-Level-3-Events
//  @see https://www.w3schools.com/jsref/dom_obj_event.asp

?>
<?php \year\widgets\CssBlock::begin() ?>
    <style>
        iframe {
            width: 1px;
            min-width: 100%;
        }
    </style>
<?php \year\widgets\CssBlock::end() ?>

<div class="test-default-index" id="iframeContainer1">


    <iframe src="<?= \yii\helpers\Url::to(['content']) ?>" id="myIframe"
            style="height:200px;width:100%;border:none;overflow:hidden;"
    ></iframe>


</div>


<?php \year\widgets\IframeResizerAsset::register($this) ?>
<?php \year\widgets\JsBlock::begin() ?>
<script>

     iFrameResize({ log: true }, '#myIframe')

    function autoResize(){
        // alert("hi");
        $('#myIframe').height($('#myIframe').contents().height());
    }
   // autoResize();
    /**
     * Resizes the given iFrame width so it fits its content
     * @param e The iframe to resize
     */
    function resizeIframeWidth(e){
        // Set width of iframe according to its content
        if (e.Document && e.Document.body.scrollWidth) //ie5+ syntax
            e.width = e.contentWindow.document.body.scrollWidth;
        else if (e.contentDocument && e.contentDocument.body.scrollWidth) //ns6+ & opera syntax
            e.width = e.contentDocument.body.scrollWidth + 35;
        else (e.contentDocument && e.contentDocument.body.offsetWidth) //standards compliant syntax – ie8
        e.width = e.contentDocument.body.offsetWidth + 35;
    }

</script>
<?php \year\widgets\JsBlock::end() ?>


<?php
\year\widgets\ElementResizeDetectorAsset::register($this) ;
\year\widgets\JsBlock::begin() ?>
<script>
    // With default options (will use the object-based approach).
    var erd = elementResizeDetectorMaker();

    // With the ultra fast scroll-based approach.
    // This is the recommended strategy.
    var erdUltraFast = elementResizeDetectorMaker({
        strategy: "scroll" //<- For ultra performance.
    });

    erd.listenTo(document.getElementById("iframeContainer1"), function(element) {
        var width = element.offsetWidth;
        var height = element.offsetHeight;
        console.log("the Size is : " + width + "x" + height);
    });
</script>
<?php \year\widgets\JsBlock::end() ?>
