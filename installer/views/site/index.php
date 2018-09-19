<?php
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h3>Welcome to yii-space!</h3>

        <p class="lead">
           按照下面的步骤开始安装吧！祝你玩得愉快.
        </p>


    </div>

    <div class="body-content">

        <div id="rootwizard">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container">
                        <ul>
                            <li><a href="#tab1" data-toggle="tab">First</a></li>
                            <li><a href="#tab2" data-toggle="tab">Second</a></li>
                            <li><a href="#tab3" data-toggle="tab">Third</a></li>
                            <li><a href="#tab4" data-toggle="tab">Forth</a></li>
                            <li><a href="#tab5" data-toggle="tab">Fifth</a></li>
                            <li><a href="#tab6" data-toggle="tab">Sixth</a></li>
                            <li><a href="#tab7" data-toggle="tab">Seventh</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="progress" id="bar">
                <div class="bar progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0"
                     aria-valuemax="100" style="width: 20%">
                    <span class="sr-only">20% Complete</span>
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane" id="tab1">
                    <?= $this->render('steps/step1') ?>
                </div>
                <div class="tab-pane" id="tab2">
                    2
                </div>
                <div class="tab-pane" id="tab3">
                    3
                </div>
                <div class="tab-pane" id="tab4">
                    4
                </div>
                <div class="tab-pane" id="tab5">
                    5
                </div>
                <div class="tab-pane" id="tab6">
                    6
                </div>
                <div class="tab-pane" id="tab7">
                    7
                </div>

                <ul class="pager wizard">
                    <li class="previous first" style="display:none;"><a href="#">First</a></li>
                    <li class="previous"><a href="javascript:void(0);">Previous</a></li>
                    <li class="next last" style="display:none;"><a href="#">Last</a></li>
                    <li class="next"><a href="javascript:void(0);">Next</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>
<?php \year\bootstrap\BootstrapWizardAsset::register($this) ?>
<?php \year\widgets\JsBlock::begin() ?>
<script>
    $(document).ready(function () {
        $('#rootwizard').bootstrapWizard({
            onTabShow: function (tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index + 1;
                var $percent = ($current / $total) * 100;
                $('#rootwizard').find('.bar').css({width: $percent + '%'});
            },
            onTabClick: function(tab, navigation, index) {
                alert('咦...... 你想弄啥！');
                return false;
            }
        });
    });
</script>
<?php \year\widgets\JsBlock::end() ?>
