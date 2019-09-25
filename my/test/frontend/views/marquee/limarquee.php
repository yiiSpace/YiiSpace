<div class="test-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>


    <div class="row">
        <div class="col s12 m6">
            <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                    <span class="card-title">Card Title</span>
                    <p>I am a very simple card. I am good at containing small bits of information.
                        I am convenient because I require little markup to use effectively.</p>
                </div>
                <div class="card-action">
                    <a href="#">This is a link</a>
                    <a href="#">This is a link</a>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col s12 m6">
            <div class="card">
                <div class="card-image">
                    <img src="images/sample-1.jpg">
                    <span class="card-title">Card Title</span>
                    <a class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>
                </div>
                <div class="card-content">

                    <div class="anyClass mWrap">
                        <div class="mMove">
                            <div class="mItem">
                                <!--Start Your Content--> In place of the text string can be any html code or picture <!--End Your Content-->

                            </div>
                        </div>
                    </div>


                    <p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.</p>
                </div>
            </div>
        </div>
    </div>






</div>

<?php \year\widgets\marquee\LiMarqueeAsset::register($this) ?>

<?php \year\widgets\CssBlock::begin() ?>
<style>

</style>
<?php \year\widgets\CssBlock::end() ?>

<?php \year\widgets\JsBlock::begin() ?>
<script>

        $(function(){
            $('.anyClass').liMarquee();
        });

</script>
<?php \year\widgets\JsBlock::end() ?>
