<?php

use yii\helpers\Html;

// use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\navigation\Nav;
use macgyer\yii2materializecss\widgets\navigation\NavBar;
use macgyer\yii2materializecss\widgets\navigation\Breadcrumbs;
use macgyer\yii2materializecss\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */



\yii\web\YiiAsset::register($this) ;

// $this->beginContent('@frontend/views/layouts/_clear.php')
$this->beginContent(__DIR__ . '/_clear.php')
?>
    <header class="page-header">
        <?php
        NavBar::begin([
            'brandLabel' => 'YiiSpace',
            'brandUrl' => Yii::$app->homeUrl,
            'fixed' => true,
            'wrapperOptions' => [
                'class' => 'container'
            ],
            'options'=>[
                 'class'=>'blue',
            ],
        ]);

        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
            $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        } else {
            $menuItems[] = '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-flat']
                )
                . Html::endForm()
                . '</li>';
        }

        echo Nav::widget([
            'options' => ['class' => 'right'],
            'items' => $menuItems,
        ]);

        NavBar::end();
        ?>
    </header>

<?= $content ?>


    <footer class="page-footer teal">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">Company Bio</h5>

                    <p class="grey-text text-lighten-4">We are a team of college students working on this project like
                        it's
                        our full time job. Any amount would help support and continue development on this project and is
                        greatly appreciated.</p>


                </div>
                <div class="col l3 s12">
                    <h5 class="white-text">Settings</h5>
                    <ul>
                        <li><a class="white-text" href="#!">Link 1</a></li>
                        <li><a class="white-text" href="#!">Link 2</a></li>
                        <li><a class="white-text" href="#!">Link 3</a></li>
                        <li><a class="white-text" href="#!">Link 4</a></li>
                    </ul>
                </div>
                <div class="col l3 s12">
                    <h5 class="white-text">Connect</h5>
                    <ul>
                        <li><a class="white-text" href="#!">Link 1</a></li>
                        <li><a class="white-text" href="#!">Link 2</a></li>
                        <li><a class="white-text" href="#!">Link 3</a></li>
                        <li><a class="white-text" href="#!">Link 4</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                Made by <a class="brown-text text-lighten-3" href="http://materializecss.com">Materialize</a>

                &copy; YiiSpace <?= date('Y') ?>

               <?= Yii::powered() ?>
            </div>
        </div>
    </footer>


<?php $this->endContent() ?>