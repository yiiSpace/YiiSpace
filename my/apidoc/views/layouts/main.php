<?php
$this->params['page-css-files'] = [
    // 'css/usercenter.css',
];

/**
 * @var yii\web\View $this
 */
// 这个地方可以根据app::end 动态决定继承哪个布局！
$this->beginContent('@app/themes/bootstrap/views/layouts/main.php');
$categories = [];
?>

    <div class="row" style="margin-top: 50px">
        <div role="main" class="col-md-10">

            <?= $content; ?>

        </div>

        <div role="complementary" class="col-md-2">
            <nav class="bs-docs-sidebar hidden-print hidden-xs hidden-sm affix">
                <ul class="nav bs-docs-sidenav">

                    <li class="active">
                        <a href="#overview">Overview</a>
                        <ul class="nav">
                            <li class="">
                                <a href="<?= \yii\helpers\Url::to(['/apidoc']) ?>">api 首页</a>
                            </li>
                            <li>
                                <a href="<?= \yii\helpers\Url::to(['category/index'])?>">api 列表</a>
                            </li>

                        </ul>
                    </li>



                </ul>
                <a href="#top" class="back-to-top">
                    Back to top
                </a>
            </nav>
        </div>

    </div>

<?= \bluezed\scrollTop\ScrollTop::widget() ?>

<?php $this->endContent() ?>