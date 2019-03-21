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
$this->beginContent(__DIR__.'/_main.php')

?>

<?= $this->render('header') ?>
    <div class="row wrap">
        <?= Html::a('logout',['/site/logout'],[
            'data'=>[
                'method'=>'post',
            ]
        ]) ?>
        layout: <?= Yii::$app->controller->layout ; ?>
<!--    使用charisma 布局是 加container 类会影响宽度的！！！
        <div class="container">   -->
        <div class="container">

            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?= $this->render('footer'); ?>

<?php $this->endContent() ?>