<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;


/**
 * @var yii\web\View $this
 */
/* @var $content string */

// 这个地方可以根据app::end 动态决定继承哪个布局！
$this->beginContent('@backend/themes/bootstrap/views/layouts/_main.php')

?>

<?= $this->render('header',[
    'no_visible_elements'=>true,
]) ?>
    <div class="row wrap">
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?= $this->render('footer',[
    'no_visible_elements'=>true,
]); ?>

<?php $this->endContent() ?>